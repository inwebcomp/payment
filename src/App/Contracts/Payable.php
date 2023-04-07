<?php

namespace InWeb\Payment\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use InWeb\Payment\Models\Payment;

/**
 * Interface Payable
 * @package InWeb\Payment\Contracts
 * @property Collection|Payment[] payments
 */
interface Payable
{
    public function setStatus($status);

    public function createPayment(Payer $payer = null, $amount = null);

    public function getPaymentAmount(Payer $payer = null);

    public function getPaymentDetail(Payer $payer = null);

    public function getCustomerDetail(Payer $payer = null);

    public function getPaymentServices(Payer $payer = null);

    /**
     * @return MorphMany
     */
    public function payments();
}
