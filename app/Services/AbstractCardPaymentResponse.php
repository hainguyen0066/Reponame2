<?php

namespace App\Services;

use App\Contract\CardPaymentResponseInterface;
use App\Util\MobileCard;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractCardPaymentResponse
 *
 * @package \App\Services
 */
abstract class AbstractCardPaymentResponse implements CardPaymentResponseInterface
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
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \App\Util\MobileCard                $card
     */
    public function __construct(ResponseInterface $response, MobileCard $card)
    {
        $this->logger = \Log::channel('card_payment');
        $this->parseResponse($response, $card);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \App\Util\MobileCard                $card
     *
     * @return mixed
     */
    abstract protected function parseResponse(ResponseInterface $response, MobileCard $card);

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
}
