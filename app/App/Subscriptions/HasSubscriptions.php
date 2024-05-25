<?php

namespace SAAS\App\Subscriptions;

trait HasSubscriptions
{
    /**
     * Get current entity's subscription.
     *
     * @param string $subscription
     * @return mixed
     */
    public function currentSubscription($subscription = 'main')
    {
        return $this->subscription($subscription);
    }

    /**
     * Determine if entity is on given plan.
     *
     * @param $providerId
     * @param string $subscription
     * @return bool
     */
    public function isOnPlan($providerId, $subscription = 'main')
    {
        return $this->subscribedToPrice($providerId, $subscription);
    }

    /**
     * Determine if entity is a customer.
     *
     * @return mixed
     */
    public function isCustomer()
    {
        return $this->hasPaymentMethod();
    }

    /**
     * Determine if entity subscription is not cancelled.
     *
     * @param string $subscription
     * @return mixed
     */
    public function hasNotCancelled($subscription = 'main')
    {
        return !$this->hasCancelled($subscription);
    }

    /**
     * Determine if entity subscription is cancelled.
     *
     * @param string $subscription
     * @return mixed
     */
    public function hasCancelled($subscription = 'main')
    {
        return optional($this->subscription($subscription))->cancelled();
    }

    /**
     * Determine if entity has no given subscription.
     *
     * @param string $subscription
     * @return mixed
     */
    public function hasNoSubscription($subscription = 'main')
    {
        return !$this->hasSubscription($subscription);
    }

    /**
     * Determine if entity has a given subscription.
     *
     * @param string $subscription
     * @return mixed
     */
    public function hasSubscription($subscription = 'main')
    {
        return $this->subscribed($subscription);
    }
}
