<?php

namespace App\Contract;

use App\Util\MobileCard;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

/**
 * Class CardPaymentInterface
 *
 * @package \App\Contract
 */
interface CardPaymentInterface
{
    const PARTNER_RECARD      = 'recard';
    const PARTNER_NAPTHENHANH = 'napthenhanh';

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * @param \App\Util\MobileCard $card
     * @param string               $paymentId
     *
     * @return \App\Contract\CardPaymentResponseInterface|null
     */
    public function useCard(MobileCard $card, $paymentId = '');

    /**
     * @param $callbackCode
     *
     * @return string
     */
    public function getCallbackMessage($callbackCode);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function getTransactionCodeFromCallback(Request $request);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array [$status, $amount, $callbackCode]
     */
    public function parseCallbackRequest(Request $request);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function logCallbackRequest(Request $request);

    /**
     * @param                          $message
     *
     * @return void
     */
    public function logCallbackProcessed($message);
}
