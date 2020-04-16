<?php

namespace InWeb\Payment\Tests;

use Illuminate\Database\Eloquent\Model;
use InWeb\Payment\Contracts\Payable;
use InWeb\Payment\Contracts\Payer;
use InWeb\Payment\PayableModel;

class TestEntity extends Model implements Payable
{
    use PayableModel;

    protected $fillable = ['*'];

    public function getPaymentAmount(Payer $payer = null)
    {
        return (float) $this->price;
    }

    public function getPaymentDetail(Payer $payer = null)
    {
        return null;
    }
}
