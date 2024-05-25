<?php

namespace SAAS\App\Payments\Gateways;

use Illuminate\Support\Facades\Log;
use SAAS\App\Payments\Gateway;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Users\Models\User;
use Stripe\Customer as StripeCustomer;

class StripeGateway implements Gateway
{
    /**
     * User instance.
     *
     * @var \SAAS\Domain\Users\Models\User
     */
    protected $user;

    /**
     * User instance to charge.
     */
    public function withUser(User $user): Gateway
    {
        $this->user = $user;

        return $this;
    }

    /**
     * User instance to charge.
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * Create's a customer in payment provider.
     *
     * @return \SAAS\App\Payments\GatewayCustomer
     *
     * @throws \Exception
     */
    public function createCustomer()
    {
        if ($this->user->gateway_customer_id) {
            return $this->getCustomer();
        }

        $customer = new StripeGatewayCustomer(
            $this,
            $this->createStripeCustomer()
        );

        $this->user->update([
            'gateway_customer_id' => $customer->id(),
        ]);

        return $customer;
    }

    /**
     * Create's a subscription plan in payment provider.
     *
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createPlan(PlanData $planData): mixed
    {
        $product = $this->createProduct($planData);

        $plan = \Stripe\Price::create([
            'nickname' => $planData->name,
            'product' => $product->id,
            'unit_amount' => $planData->price,
            'currency' => config('cashier.currency'),
            'recurring' => [
                'interval' => $planData->interval,
                'usage_type' => $planData->per_seat ? 'metered' : 'licensed',
            ],
        ]);

        return $plan;
    }

    protected function createProduct(PlanData $planData): \Stripe\Product
    {
        $product = $this->retrieveProduct($planData);
        if ($product) {
            return $product;
        }

        return \Stripe\Product::create([
            'name' => $planData->name,
            'id' => $planData->provider_id,
        ]);
    }

    protected function retrieveProduct(PlanData $planData): ?\Stripe\Product
    {
        try {
            if (($product = \Stripe\Product::retrieve($planData->provider_id, []))) {
                return $product;
            }
        } catch (\Exception $e) {
            Log::error('Failed retrieving Stripe product.', [$e]);
        }

        return null;
    }

    public function deletePlan(PlanData $planData): bool
    {
        try {
            if (($product = \Stripe\Price::update($planData->gateway_id, ['active' => false]))) {
                return $product->active == false;
            }
        } catch (\Exception $e) {
            Log::error('Failed deleting plan from Stripe.', [$e]);

            throw $e;
        }

        return false;
    }

    /**
     * @return \SAAS\App\Payments\Gateways\StripeGatewayCustomer
     *
     * @throws \Exception
     */
    public function getCustomer()
    {
        return new StripeGatewayCustomer(
            $this,
            StripeCustomer::retrieve($this->user->gateway_customer_id)
        );
    }

    /**
     * @return \Stripe\Customer
     *
     * @throws \Exception
     */
    protected function createStripeCustomer()
    {
        return StripeCustomer::create([
            'email' => $this->user->email,
        ]);
    }
}
