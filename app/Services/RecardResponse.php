<?php

namespace App\Services;

use Psr\Http\Message\ResponseInterface;

/**
 * Class RecardResponse
 *
 * @package \App\Services
 */
class RecardResponse
{

    public static $callbackReason = [
        1 => "Thẻ không tồn tại",
        2 => "Thẻ đã được sử dụng",
        3 => "Thẻ không sử dụng được",
        4 => "Thẻ sai mệnh giá",
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
     * RecardResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->body = $response->getBody()->getContents();
        $result = json_decode($this->body, 1);
        if ($this->statusCode != 200) {
            $this->errors = $result;
        }
        if ($this->statusCode == 200 && !empty($result['success']) && !empty($result['transaction_code'])) {
            $this->success = true;
            $this->transactionCode = $result['transaction_code'];
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $reason
     *
     * @return mixed|string
     */
    public static function getReasonPhrase($reason)
    {
        return isset(self::$callbackReason[$reason]) ? self::$callbackReason[$reason] : "Unknown reason `{$reason}`";
    }

}
