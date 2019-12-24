<?php

namespace InWeb\Payment\Contracts;

interface Payable
{
    public function createPayment(Payer $payer);

    public function getPaymentAmount(Payer $payer);

    public function getPaymentDetail(Payer $payer);
}