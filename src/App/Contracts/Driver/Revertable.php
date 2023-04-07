<?php

namespace InWeb\Payment\Contracts\Driver;

use InWeb\Payment\Models\Payment;

interface Revertable {
    public function revertTransaction(Payment $payment, ?float $amount): bool;
}
