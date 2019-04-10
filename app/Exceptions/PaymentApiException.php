<?php

namespace App\Exceptions;

use App\Models\Payment;

/**
 * Class PaymentApiException
 *
 * @package \App\Http\Controllers\Admin
 */
class PaymentApiException extends \Exception
{
    const GAME_PAYMENT_API_ERROR_CODE = 1;
    /**
     * @var
     */
    protected $payment;

    /**
     * @param \App\Models\Payment $payment
     */
    public function setPaymentItem(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getPaymentItem()
    {
        return $this->payment;
    }
}
