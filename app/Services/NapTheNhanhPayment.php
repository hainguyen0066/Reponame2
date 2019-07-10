<?php

namespace App\Services;

use App\Contract\CardPaymentInterface;
use App\Util\MobileCard;

/**
 * Class NapTheNhanhPayment
 *
 * @package \App\Services
 */
class NapTheNhanhPayment implements CardPaymentInterface
{
    const ENDPOINT = "/api/charging-wcb";
    const BASE_URL = "http://sys.napthenhanh.com";
    const CARD_TYPE_VIETTEL = 'VIETTEL';
    const CARD_TYPE_MOBIFONE = 'MOBIFONE';
    const CARD_TYPE_VINAPHONE = 'VINAPHONE';

    public static $callbackReason = [
        0 => "Thẻ không hợp lệ",
        2 => "Thẻ đang chờ xử lý",
        3 => "Thẻ sai mệnh giá",
    ];

    /**
     * @var string
     */
    private $partnerId;

    /**
     * @var string
     */
    private $partnerKey;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct($partnerId, $partnerKey)
    {
        $this->partnerId = $partnerId;
        $this->partnerKey = $partnerKey;
        if (env('CARD_PAYMENT_API_MOCK', false)) {
            $this->client = new CardPaymentApiClientMocked();
        } else {
            $this->client = new \GuzzleHttp\Client([
                'base_uri'    => self::BASE_URL,
                'timeout'     => 60,
                'http_errors' => false,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function useCard(MobileCard $card, $paymentId = '')
    {
        $signature = $this->sign($card, $paymentId);
        $params['form_params'] = [
            'partner_id' => $this->partnerId,
            'type'       => $this->getCardType($card),
            'serial'     => $card->getSerial(),
            'pin'        => $card->getCode(),
            'amount'     => $card->getAmount(),
            'sign'       => $signature,
            'tranid'     => $paymentId,
        ];
        $response = $this->client->post(self::ENDPOINT, $params);

        return new NapTheNhanhResponse($response, $card);
    }

    /**
     * @param \App\Util\MobileCard $card
     * @param                      $paymentId
     *
     * @return string
     */
    private function sign(MobileCard $card, $paymentId)
    {
        $type = $this->getCardType($card);
        $signature = $this->partnerId . $this->partnerKey . $type . $card->getCode() . $card->getSerial() . $card->getAmount() . $paymentId;

        return md5($signature);
    }

    /**
     * @param \App\Util\MobileCard $card
     *
     * @return int
     */
    private function getCardType(MobileCard $card)
    {
        $type = strtoupper($card->getType());
        switch ($type) {
            case MobileCard::TYPE_VIETTEL:
                return self::CARD_TYPE_VIETTEL;
            case MobileCard::TYPE_MOBIFONE:
                return self::CARD_TYPE_MOBIFONE;
            case MobileCard::TYPE_VINAPHONE:
                return self::CARD_TYPE_VINAPHONE;
        }

        return false;
    }

    /**
     * @param $callbackCode
     *
     * @return string
     */
    public function getCallbackMessage($callbackCode)
    {
        return isset(self::$callbackReason[$callbackCode]) ? self::$callbackReason[$callbackCode] : "Lỗi không xác định `{$callbackCode}`";
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function getTransactionCodeFromCallback(\Illuminate\Http\Request $request)
    {
        return $request->get('tranid');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array [$status, $amount, $reason]
     */
    public function parseCallbackRequest(\Illuminate\Http\Request $request)
    {
        $status = intval($request->get('status')) == 1 ? true : false;
        $responseCode = $request->get('status');
        $amount = intval($request->get('amount'));

        return [$status, $amount, $responseCode];
    }
}
