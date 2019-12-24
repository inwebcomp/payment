<?php

namespace InWeb\Payment\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use InWeb\Payment\Contracts\Payer;

class PaymentTestCase extends TestCase
{
    use DatabaseMigrations;
    /**
     * @var Payer
     */
    public $payer;

    protected function setUp() : void
    {
        parent::setUp();

        // @todo Make this unrelated to User model
        $this->payer = factory(User::class)->create();
    }

    /**
     * @return TestEntity
     */
    public static function createOrder()
    {
        $order = factory(TestEntity::class)->create();
        $order->price = rand(1000, 99999) / 10;

        return $order;
    }
}
