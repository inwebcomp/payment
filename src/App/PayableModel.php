<?php

namespace InWeb\Payment;

use App\Models\Order;
use InWeb\Payment\Contracts\Payable;
use InWeb\Payment\Contracts\Payer;
use InWeb\Payment\Models\Payment;

trait PayableModel
{
    /**
     * @param Payer $payer
     * @return \Illuminate\Database\Eloquent\Model|Payment
     */
    public function createPayment(Payer $payer)
    {
        return $payer->payments()->create([
            'payer_type'   => get_class($payer),
            'payer_id'     => $payer->getKey(),
            'payable_type' => get_class($this),
            'payable_id'   => $this->getKey(),
            'status'       => Payment::STATUS_PENDING,
            'amount'       => $this->getPaymentAmount($payer),
            'detail'       => $this->getPaymentDetail($payer),
        ]);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}