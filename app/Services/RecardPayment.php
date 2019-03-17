<?php

namespace App\Services;

use App\Util\MobileCard;

/**
 * Class RecardPayment
 *
 * @package \App\Services
 */
class RecardPayment
{
    const ENDPOINT = "/api/card";
    const BASE_URL = "https://recard.vn";
    const CARD_TYPE_VIETTEL = 1;
    const CARD_TYPE_MOBIFONE = 2;
    const CARD_TYPE_VINAPHONE = 3;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct($merchantId, $secretKey)
    {
        $this->merchantId = $merchantId;
        $this->secretKey = $secretKey;
        $this->client = new \GuzzleHttp\Client([
            'base_uri'    => self::BASE_URL,
            'timeout'     => 60,
            'http_errors' => false,
        ]);
    }

    /**
     * @param \App\Util\MobileCard $card
     *
     * @return \App\Services\RecardResponse
     */
    public function useCard(MobileCard $card)
    {
        $signature = $this->sign($card);
        $params['form_params'] = [
            'merchant_id' => $this->merchantId,
            'secret_key'  => $this->secretKey,
            'type'        => $this->getCardType($card),
            'serial'      => $card->getSerial(),
            'code'        => $card->getCode(),
            'amount'      => $card->getAmount(),
            'signature'   => $signature,
        ];
        $response = $this->client->post(self::ENDPOINT, $params);

        return new RecardResponse($response);
    }

    /**
     * @param $card
     *
     * @return string
     */
    private function sign(MobileCard $card)
    {
        $type = $this->getCardType($card);
        $data = $this->merchantId . $type . $card->getSerial() . $card->getCode() . $card->getAmount();

        return hash_hmac('sha256', $data, $this->secretKey);
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
}
