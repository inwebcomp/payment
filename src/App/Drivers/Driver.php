<?php

namespace InWeb\Payment\Drivers;

use InWeb\Payment\Enums\TransactionState;
use InWeb\Payment\Models\Payment;

abstract class Driver
{
    const PAYMENT_STATUS_SUCCESS = null;

    abstract public function createPayment(Payment $payment, ?string $successPath = null, ?string $cancelPath = null, $buttonInfo = null): Payment;

    abstract public function isSuccessfulPayment(Payment $payment): bool;

    abstract public function getPaymentStatus(Payment $payment): TransactionState;
}
