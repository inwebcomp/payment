<?php

namespace InWeb\Payment;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use InWeb\Payment\Models\Payment;

trait PayerModel
{
    /**
     * @return MorphMany
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payer');
    }
}