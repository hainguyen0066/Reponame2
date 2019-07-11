<?php

namespace App\Services;

use App\Contract\CardPaymentInterface;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractCardPayment
 *
 * @package \App\Services
 */
abstract class AbstractCardPayment implements CardPaymentInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \App\Contract\CardPaymentInterface|void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function logCallbackRequest(Request $request)
    {
        $this->logger->info("Card payment callback received", ['data' => $request->all(), 'gateway' => env('CARD_PAYMENT_PARTNER')]);
    }

    /**
     * @inheritdoc
     */
    public function logCallbackProcessed($message)
    {
        $this->logger->info("Card payment callback processed", ['status' => $message, 'gateway' => env('CARD_PAYMENT_PARTNER')]);
    }
}
