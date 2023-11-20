<?php

namespace InWeb\Payment\Contracts\Driver;

use InWeb\Payment\Models\Payment;

interface HasCheckPaymentStatusJob {
    public function handleJobCheckPaymentStatus(Payment $payment): void;
}
