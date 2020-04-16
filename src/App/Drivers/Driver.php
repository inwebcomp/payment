<?php

namespace InWeb\Payment\Drivers;

use InWeb\Payment\Models\Payment;

abstract class Driver
{
    const PAYMENT_STATUS_SUCCESS = null;

    abstract public function createPayment(Payment $payment, $successPath, $cancelPath, $buttonInfo = null);

    abstract public function getPaymentInfo(Payment $payment);
}