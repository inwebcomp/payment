<?php

namespace InWeb\Payment\Tests\Unit;

use InWeb\Payment\Tests\PaymentTestCase;

class PaymentTest extends PaymentTestCase
{
    /** @test */
    public function can_create_payment_with_payer()
    {
        $object = $this->createOrder();

        $payment = $object->createPayment($this->payer);

        $this->assertTrue($payment->payable instanceof $object);
        $this->assertEquals($payment->payable->getKey(), $object->getKey());

        $this->assertTrue($payment->payer instanceof $this->payer);
        $this->assertEquals($payment->payer->getKey(), $this->payer->getKey());

        $this->assertEquals($payment->amount, $object->price);
    }

    /** @test */
    public function can_create_payment_without_payer()
    {
        $object = $this->createOrder();

        $payment = $object->createPayment();

        $this->assertTrue($payment->payable instanceof $object);
        $this->assertEquals($payment->payable->getKey(), $object->getKey());

        $this->assertNull($payment->payer);

        $this->assertEquals($payment->amount, $object->price);
    }
}
