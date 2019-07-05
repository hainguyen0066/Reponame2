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
     * @param $reasonCode
     *
     * @return string
     */
    public function getReasonPhrase($reasonCode);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function getTransactionCodeFromCallback(\Illuminate\Http\Request $request);

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array [$status, $amount, $reason]
     */
    public function parseCallbackRequest(\Illuminate\Http\Request $request);
}
