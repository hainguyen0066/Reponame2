<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * @param \App\Models\Payment $payment
     */
    public function saving(Payment $payment)
    {
        $payment->status_code = Payment::getPaymentStatus($payment);
    }

}
