<?php

namespace SAAS\App\Payments\Gateways;

use Illuminate\Database\Eloquent\Model;
use SAAS\App\Payments\Exceptions\PaymentFailedException;
use SAAS\App\Payments\Gateway;
use SAAS\App\Payments\GatewayCustomer;
use Stripe\Charge as StripeCharge;
use Stripe\Customer as StripeCustomer;

class StripeGatewayCustomer implements GatewayCustomer
{
    /**
     * Gateway instance.
     *
     * @var \SAAS\App\Payments\Gateway
     */
    protected $gateway;

    /**
     * Stripe Customer instance.
     *
     * @var \Stripe\Customer
     */
    protected $customer;

    /**
     * StripeGatewayCustomer constructor.
     *
     * @return void
     */
    public function __construct(Gateway $gateway, StripeCustomer $customer)
    {
        $this->gateway = $gateway;
        $this->customer = $customer;
    }

    /**
     * @param  int|\SAAS\App\Support\Money  $amount
     * @return mixed
     */
    public function charge(Model $paymentMethod, $amount)
    {
        try {
            StripeCharge::create([
                'currency' => config('cashier.currency'),
                'amount' => $amount,
                'customer_id' => $this->customer->id,
                'source' => $paymentMethod->provider_id,
            ]);
        } catch (\Exception $e) {
            throw new PaymentFailedException();
        }
    }

    /**
     * Add a card to Stripe and save it in storage.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function addCard($token)
    {
        $card = $this->customer->sources->create([
            'source' => $token,
        ]);

        // set card as default in "Stripe"
        $this->customer->default_source = $card->id;
        $this->customer->save();

        return $this->gateway->user()->paymentMethods()->create([
            'card_type' => $card->brand,
            'last_four' => $card->last4,
            'provider_id' => $card->id,
            'default' => true,
        ]);
    }

    public function id()
    {
        return $this->customer->id;
    }
}
