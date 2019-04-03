<?php

namespace App\Repository;

use App\Models\Payment;
use App\Services\RecardResponse;
use App\User;
use App\Util\CommonHelper;
use App\Util\MobileCard;

/**
 * Class PaymentRepository
 *
 * @package \App\Repository
 */
class PaymentRepository extends AbstractEloquentRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Payment::class;
    }

    /**
     * @param \App\Util\MobileCard $card
     *
     * @return int
     */
    public function isCardExisted(MobileCard $card)
    {
        $query = $this->query();
        $query->where('card_pin', 'LIKE', $card->getCode())
            ->where('card_serial', 'LIKE', $card->getSerial())
            ->where('card_type', $card->getType())
        ;

        return $query->count();
    }

    /**
     * @param \App\Models\Payment  $payment
     * @param                      $transactionCode
     *
     * @return \App\Models\Payment
     */
    public function updateRecardPayment(Payment $payment, $transactionCode)
    {
        $payment->transaction_id = $transactionCode;
        $payment->pay_from = "ReCard";
        $payment->pay_method = "ReCard";
        $payment->save();

        return $payment;
    }

    /**
     * @param \App\Models\Payment $payment
     *
     * @return \App\Models\Payment
     */
    public function updateZingCardPayment(Payment $payment)
    {
        $payment->pay_from = "ZingCard";
        $payment->pay_method = "ZingCard";
        $payment->save();

        return $payment;
    }

    /**
     * @param \App\User            $user
     * @param \App\Util\MobileCard $card
     * @param                      $gameCoin
     *
     * @return \App\Models\Payment
     */
    public function createCardPayment(User $user, MobileCard $card, $gameCoin)
    {
        $data = [
            'card_type'   => $card->getType(),
            'card_serial' => $card->getSerial(),
            'card_pin'    => $card->getCode(),
            'card_amount' => $card->getAmount(),
        ];
        $payment = $this->createPayment($user, Payment::PAYMENT_TYPE_CARD, $card->getAmount(), $gameCoin, $data);

        return $payment;
    }

    public function createPayment(User $user, $type, $amount, $gamecoin, $extraData)
    {
        $payment = new Payment();
        $data = [
            'user_id'      => $user->id,
            'username'     => $user->name,
            'payment_type' => $type,
            'amount'       => $amount,
            'gamecoin'     => $gamecoin,
            'ip'           => request()->getClientIp(),
            'utm_medium'   => $user->utm_medium,
            'utm_source'   => $user->utm_source,
            'utm_campaign' => $user->utm_campaign,
            'creator_id'   => \Auth::user()->id,
            'pay_from'     => Payment::displayPaymentType($type),
        ];
        $data = array_merge($data, $extraData);
        foreach ($data as $attribute => $value) {
            $payment->{$attribute} = $value;
        }
        $payment->save();

        return $payment;
    }

    /**
     * @param $transactionCode
     *
     * @return Payment|null
     */
    public function getByTransactionCode($transactionCode)
    {
        $query = $this->query();
        $query->where('transaction_id', $transactionCode);

        return $query->first();
    }

    public function updateRecardTransaction(Payment $record, $status, $reason, $amount)
    {
        $reasonPhrase = $status == 2 ? RecardResponse::getReasonPhrase($reason) : '';
        $record->gateway_status = boolval($status);
        $record->gateway_response = $reasonPhrase;
        $record->gateway_amount = $amount;
        $record->finished = true;
        $record->save();
    }

    public function updateRecordAddedGold(Payment $record, $status)
    {
        $record->gold_added = $status;
        $record->status     = $status;
        $record->finished   = true;
        $record->save();
    }

    public function makeUserPaymentHistoryQuery(User $user)
    {
        $query = $this->query();
        $query->whereUserId($user->id);

        return $query;
    }

    public function getUserPaymentHistory(User $user, $limit = 10)
    {
        $query = $this->makeUserPaymentHistoryQuery($user);

        return $query->paginate($limit);
    }

    /**
     * @param $moneyAmount
     * @param $paymentType
     *
     * @return array
     */
    public function exchangeGamecoin($moneyAmount, $paymentType)
    {
        $knb = $xu = 0;
        $gameCoinAmount = ceil($moneyAmount / env('GOLD_EXCHANGE_RATE', 1000));
        if ($paymentType == Payment::PAYMENT_TYPE_BANK_TRANSFER || $paymentType == Payment::PAYMENT_TYPE_MOMO) {
            $xu = $gameCoinAmount + ceil($gameCoinAmount * env('GOLD_EXCHANGE_BONUS', 20) / 100);
        } else {
            $knb = $gameCoinAmount;
        }

        return [$knb, $xu];
    }

    /**
     * @param \App\Models\Payment $payment
     * @param bool                $status
     * @param bool                $goldAdded
     *
     * @return \App\Models\Payment
     */
    public function setDone(Payment $payment, $status = true, $goldAdded = true)
    {
        $payment->finished = true;
        $payment->status = $status;
        $payment->gold_added = $goldAdded;
        $payment->save();

        return $payment;
    }

    /**
     * @param \App\Models\Payment $payment
     *
     * @return \App\Models\Payment
     */
    public function setFailed(Payment $payment)
    {
        $payment->finished = true;
        $payment->status = false;
        $payment->gold_added = false;
        $payment->note = "Cập nhật bởi Moderator";
        $payment->save();

        return $payment;
    }

    function getRevenueChartData($fromDate, $toDate){
        $count = CommonHelper::subDate($fromDate, $toDate);
        $results = \DB::table('payments')->selectRaw("DATE_FORMAT(`created_at`, '%d-%m') AS `date`, `pay_from`, SUM(`amount`)/1000 as `total`")
            ->whereRaw("`created_at` BETWEEN '{$fromDate} 00:00:00' AND '{$toDate} 23:59:59' AND `status` = 1")
            ->groupBy('pay_from', 'date')
            ->orderBy('date', 'ASC')
            ->get()
        ;
        //order data
        $data = $payfroms = [];
        for($i = 0; $i <= $count; $i ++){
            $startOfDay = mktime(0, 0, 0, date('n', strtotime($fromDate)), date('d', strtotime($fromDate)) + $i);
            $day = date('d-m', $startOfDay);
            foreach ($results as $key => $value) {
                if (!in_array($value->pay_from, $payfroms)) {
                    $payfroms[] = $value->pay_from;
                }
                if ($value->date == $day) {
                    $data[$day][$value->pay_from] = $value->total;
                }
            }
        }
        $series = $seriesData = [];
        $total = 0;
        foreach ($data as $key => $val) {
            $series[] = "'$key'";
            foreach ($payfroms as $name) {
                $payByDay = isset($val[$name]) ? $val[$name] : 0;
                $seriesData[$name][] = $payByDay;
                $total += $payByDay;
            }
        }

        return [
            'series'     => implode(',', $series),
            'seriesData' => $seriesData,
            'total'      => $total,
        ];
    }

    /**
     * @param      $fromDate
     * @param null $toDate
     *
     * @return mixed
     */
    public function getRevenueByPeriod($fromDate = null, $toDate = null)
    {
        $query = $this->query();
        if ($fromDate) {
            $query->where('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->where('created_at', '<=', $toDate);
        }
        $total = $query->where('status', 1)
            ->sum('amount')
        ;

        return $total;
    }
}
