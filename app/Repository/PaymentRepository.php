<?php

namespace App\Repository;

use App\Models\Payment;
use App\Models\Server;
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
        if ($card->getType() != MobileCard::TYPE_ZING) {
            $query->where('status', 1);
        }

        return $query->count();
    }

    /**
     * @param \App\User            $user
     * @param \App\Util\MobileCard $card
     * @param \App\Models\Server   $server
     * @param                      $transactionCode
     * @param                      $gameCoin
     *
     * @return int
     */
    public function createRecardPayment(User $user, MobileCard $card, Server $server, $transactionCode, $gameCoin)
    {
        $record = new Payment();
        $params = $this->createPayment($user, $card, $server, $gameCoin);
        $params['transaction_id'] = $transactionCode;
        $params['pay_from'] = 'ReCard';
        $params['pay_method'] = 'ReCard';
        foreach ($params as $param => $value) {
            $record->{$param} = $value;
        }
        $record->save();

        return $record->id;
    }

    /**
     * @param \App\User            $user
     * @param \App\Util\MobileCard $card
     * @param \App\Models\Server   $server
     * @param                      $gameCoin
     *
     * @return array
     */
    private function createPayment(User $user, MobileCard $card, Server $server, $gameCoin)
    {
        $log = [
            'username'     => $user->name,
            'payment_type' => Payment::PAYMENT_TYPE_MOBILECARD,
            'server_id'    => $server->game_server_id,
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

        return $log;
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
