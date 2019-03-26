<?php

namespace App\Action;

use App\Models\Payment;
use TCG\Voyager\Actions\AbstractAction;

/**
 * Class AcceptPaymentAction
 *
 * @package \App\Action
 */
class AcceptPaymentAction extends AbstractAction
{

    public function getTitle()
    {
        return "OK";
    }

    public function getIcon()
    {
        return "voyager-check";
    }

    public function getPaymentsRoute()
    {
        return route('voyager.payments.accept', [$this->data->id]);
    }

    public function getDefaultRoute()
    {
        return route('voyager.payments.browse');
    }

    public function shouldActionDisplayOnDataType()
    {
        /** @var \App\Models\Payment $payment */
        $payment = $this->data;
        if ($this->dataType->slug != 'payments') {
            return false;
        }

        return Payment::isAcceptable($payment);
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-success pull-right'
        ];
    }
}
