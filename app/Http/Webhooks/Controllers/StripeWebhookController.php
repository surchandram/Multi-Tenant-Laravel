<?php

namespace SAAS\Http\Webhooks\Controllers;

use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Payments\Models\Payment;
use SAAS\Domain\Users\Models\User;

class StripeWebhookController extends WebhookController
{
    public function chargeSucceeded($payload)
    {
        // \Illuminate\Support\Facades\Log::info('chargeSucceeded', $payload);
    }

    public function handlePaymentIntentSucceeded($payload)
    {
        // Log::info('handlePaymentIntentSucceeded', $payload);

        $charge = $payload['data']['object'];

        $payable = User::where('stripe_id', $charge['customer'])->first();

        if (! $payable) {
            $payable = Company::where('stripe_id', $charge['customer'])->first();
        }

        if ($payable) {
            try {
                // todo: move to action
                $payment = new Payment();
                if ($payable) {
                    $payment->payable()->associate($payable);
                }
                $payment->gateway = 'stripe';
                $payment->gateway_id = $charge['id'];
                $payment->subtotal = $charge['amount'];
                $payment->total = $charge['amount'];
                $payment->save();
            } catch (\Exception $e) {
                Log::error('Payment logging failed.', ['message' => $e->getMessage(), 'trace' => $e->getTrace()]);
            }
        } else {
            Log::warning('Payment without customer data when trying to log [handlePaymentIntentSucceeded]', $payload);
        }
    }
}
