<?php

namespace App\Repository;

use App\Models\Payment;
use App\Services\RecardResponse;
use App\User;
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
    public function createPayment(User $user, MobileCard $card, $gameCoin)
    {
        $payment = new Payment();
        $data = [
            'username'     => $user->name,
            'card_type'    => $card->getType(),
            'card_serial'  => $card->getSerial(),
            'card_pin'     => $card->getCode(),
            'card_amount'  => $card->getAmount(),
            'gamecoin'     => $gameCoin,
            'ip'           => request()->getClientIp(),
            'utm_medium'   => $user->utm_medium,
            'utm_source'   => $user->utm_source,
            'utm_campaign' => $user->utm_campaign,
        ];
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
        $query->where('transaction_id', $transactionCode)
            ->where('finished','!=', 1)
        ;

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
}
