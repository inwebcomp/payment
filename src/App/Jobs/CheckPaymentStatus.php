<?php

namespace InWeb\Payment\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InWeb\Payment\Models\Payment;

class CheckPaymentStatus implements ShouldQueue
{
    use Dispatchable, SerializesModels, Queueable, InteractsWithQueue;

    public int $tries = 2;
    public int $timeout = 30;

    public function handle()
    {
        $paymentDriver = app('payment');

        if (!($paymentDriver instanceof \InWeb\Payment\Contracts\Driver\HasCheckPaymentStatusJob)) {
            return;
        }

        /** @var Payment[] $payments */
        $payments = Payment::where('status', Payment::STATUS_INPROGRESS)->get();

        $daysToCancelPayment = config('payment.days_to_cancel_payment');

        foreach ($payments as $payment) {
            $paymentDriver->handleJobCheckPaymentStatus($payment);

            if ($payment->process_start_at->diffInDays() > $daysToCancelPayment) {
                \Log::critical('Payment canceled by timeout', [
                    'payment_id' => $payment->id,
                    'created_at' => $payment->created_at->toDateTimeString(),
                    'diff_in_days' => $payment->created_at->diffInDays(),
                ]);

                $payment->cancel();
            }
        }
    }
}
