<?php

namespace App\Contract;

use App\Util\MobileCard;

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
    public function getTransactionCodeFromCallback(\Illuminate\Http\Request $request);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array [$status, $amount, $callbackCode]
     */
    public function parseCallbackRequest(\Illuminate\Http\Request $request);
}
