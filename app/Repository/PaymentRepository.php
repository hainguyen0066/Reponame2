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
    public function addLogRecard(User $user, MobileCard $card, Server $server, $transactionCode, $gameCoin)
    {
        $record = new Payment();
        $params = $this->createLog($user, $card, $server, $gameCoin);
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
    private function createLog(User $user, MobileCard $card, Server $server, $gameCoin)
    {
        $log = [
            'username'     => $user->name,
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

        $now = time();
        if ($now > strtotime("2019-01-03 00:00:00") && $now < strtotime("2019-01-09 23:59:59")) {
            $log['gamecoin_promotion'] = ceil($gameCoin * 0.5);
        }

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
}
