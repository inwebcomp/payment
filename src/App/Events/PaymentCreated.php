<?php

namespace InWeb\Payment\Events;

use Illuminate\Foundation\Events\Dispatchable;

class PaymentCreated
{
    use Dispatchable;

    public $payment;

    /**
     * @param \InWeb\Payment\Models\Payment $payment
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }
}
