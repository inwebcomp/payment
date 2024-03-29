<?php

namespace InWeb\Payment\Drivers\Paynet;

use InWeb\Payment\Contracts\Payable;
use InWeb\Payment\Drivers\Driver;
use InWeb\Payment\Models\Payment;

class Paynet extends Driver
{
    private $api;

    const PAYMENT_STATUS_SUCCESS = 4;

    public function __construct()
    {
        $this->api = new PaynetAPI(
            config('payment.paynet.code'),
            config('payment.paynet.secret'),
            config('payment.paynet.user'),
            config('payment.paynet.password'),
            config('payment.paynet.base_url')
        );
    }

    public function createPayment(Payment $payment, ?string $successPath = null, ?string $cancelPath = null, $buttonInfo = null): Payment
    {
        /** @var Payable $payable */
        $payable = $payment->payable;

        /** @var Payer $payer */
        $payer = $payment->payer;

        if (!$successPath) {
            throw new \Exception('Success path is required');
        }

        if (!$cancelPath) {
            throw new \Exception('Cancel path is required');
        }

        $prequest = new PaynetRequest();
        $prequest->ExternalID = $payment->id;
        $prequest->LinkSuccess = $successPath;
        $prequest->LinkCancel = $cancelPath;
        $prequest->Lang = \App::getLocale();

        $prequest->Amount = (int) $payment->amount * 100;

        $prequest->Services = $payable->getpaymentServices();

        $prequest->Customer = $payable->getCustomerDetail($payer);

        $button = $this->createButton($buttonInfo);

        $paymentRegObj = $this->api->PaymentReg($prequest, $button);

        if (! $paymentRegObj->Data)
            \Log::critical("Can't create payment form", $paymentRegObj->toArray());

        return $paymentRegObj->Data;
    }

    public function paymentButton($operationId, $successPath, $cancelPath, $buttonInfo = [])
    {
//        $payment = Order::find($operationId)->payments()->first();
//
////        $data = $this->getPaymentInfo($payment);
////        dd($data);
//        $data = $this->createPayment($payment->id, $successPath, $cancelPath);
////        dd($data);
////        $button = $this->createButton($buttonInfo);
//
//        return $this->api->getPaymentFormButton($operationId, $successPath, $cancelPath, $button);
    }

    public function getPaymentInfo(Payment $payment)
    {
        $paymentRegObj = $this->api->PaymentGet($payment->id);

        return is_array($paymentRegObj->Data) ? current($paymentRegObj->Data) : null;
    }

    private function createButton($buttonInfo)
    {
        if (! $buttonInfo)
            return null;

        return '<button type="submit" class="' . implode($buttonInfo['classes']) . '">' . $buttonInfo['text'] . '</button>';
    }

    public function isSuccessPayment($status)
    {
        return $status == self::PAYMENT_STATUS_SUCCESS;
    }
}
