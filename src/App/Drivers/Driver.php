<?php

namespace InWeb\Payment\Drivers;

use InWeb\Payment\Models\Payment;

abstract class Driver
{
    const PAYMENT_STATUS_SUCCESS = null;

    abstract public function createPayment(Payment $payment, $successPath, $cancelPath, $buttonInfo = null): Payment;

    abstract public function isSuccessfulPayment(Payment $payment): bool;
}
