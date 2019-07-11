<?php

namespace App\Services;

use App\Util\MobileCard;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NapTheNhanhResponse
 *
 * @package \App\Services
 */
class NapTheNhanhResponse extends AbstractCardPaymentResponse
{
    const RESPONSE_STATUS_SUCCESS = 2;

    public static $callbackReason = [
        0   => "Thẻ không sử dụng được",
        3   => "Thẻ sai mệnh giá",
        999 => "Thẻ không sử dụng được",
    ];

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
    protected $success = false;

    /**
     * @var string
     */
    protected $transactionCode;

    /**
     * @var array
     */
    protected $errors = [];

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
        if (!empty($result['status']) && $result['status'] == self::RESPONSE_STATUS_SUCCESS && !empty($result['tranid'])) {
            $this->success = true;
            $this->transactionCode = $result['tranid'];
        } else {
            $this->logger->info("Napthenhanh response with error", [
                'card'       => $card,
                'response'   => $this->body,
                'statusCode' => $this->statusCode,
            ]);
            $this->errors = [$result['message'] ?? 'Có lỗi xảy ra'];
        }
    }
}
