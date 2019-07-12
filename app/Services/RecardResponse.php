<?php

namespace App\Services;

use App\Util\MobileCard;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RecardResponse
 *
 * @package \App\Services
 */
class RecardResponse extends AbstractCardPaymentResponse
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string
     */
    protected $transactionCode;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param $reason
     *
     * @return mixed|string
     */
    public function getCallbackMessage($reason)
    {
        return isset(self::$callbackReason[$reason]) ? self::$callbackReason[$reason] : "Unknown reason `{$reason}`";
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \App\Util\MobileCard                $card
     *
     * @return mixed
     */
    protected function parseResponse(ResponseInterface $response, MobileCard $card)
    {
        $this->statusCode = $response->getStatusCode();
        $this->body = $response->getBody()->getContents();
        $result = json_decode($this->body, 1);
        if ($this->statusCode != 200) {
            $this->logger->info("ReCard response with error", [
                'card'       => $card,
                'response'   => $this->body,
                'statusCode' => $this->statusCode,
            ]);
            if (isset($result['statusCode'])) {
                unset($result['statusCode']);
            }
            $this->errors = array_values($result);
        }
        if ($this->statusCode == 200 && !empty($result['success']) && !empty($result['transaction_code'])) {
            $this->success = true;
            $this->transactionCode = $result['transaction_code'];
        }
    }
}
