<?php

namespace InWeb\Payment\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClosePaymentDay implements ShouldQueue
{
    use Dispatchable, SerializesModels, Queueable, InteractsWithQueue;

    public int $tries = 2;
    public int $timeout = 30;

    public function handle()
    {
        $paymentDriver = app('payment');

        if ($paymentDriver instanceof \InWeb\Payment\Contracts\Driver\DayShouldBeClosed) {
            $paymentDriver->closeDay();
        }
    }
}
