<?php

namespace InWeb\Payment;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use InWeb\Payment\Contracts\Payer;
use InWeb\Payment\Models\Payment;

trait PayableModel
{
    /**
     * @param Payer $payer
     * @param null  $amount
     * @return \Illuminate\Database\Eloquent\Model|Payment
     * @throws \Throwable
     */
    public function createPayment(Payer $payer = null, $amount = null)
    {
        $dbPayment = \DB::transaction(function () use ($payer, $amount) {
            $dbPayment = $this->payments()->create([
                'payer_type'   => $payer ? get_class($payer) : null,
                'payer_id'     => $payer ? $payer->getKey() : null,
                'payable_type' => get_class($this),
                'payable_id'   => $this->getKey(),
                'status'       => Payment::STATUS_PENDING,
                'amount'       => $amount ?? $this->getPaymentAmount($payer),
                'detail'       => $this->getPaymentDetail($payer),
            ]);

            \InWeb\Payment\Payment::createPayment($dbPayment, '', '');

            return $dbPayment;
        });

        return $dbPayment;
    }

    /**
     * @return MorphMany
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function pendingPayments()
    {
        return $this->payments()->where('status', Payment::STATUS_PENDING);
    }
}
