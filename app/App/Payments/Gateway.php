<?php

namespace SAAS\App\Payments;

use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Users\Models\User;

interface Gateway
{
    /**
     * User instance to charge.
     */
    public function withUser(User $user): Gateway;

    /**
     * Create's a customer in payment provider.
     *
     * @return \SAAS\App\Payments\GatewayCustomer
     */
    public function createCustomer();

    /**
     * Create's a subscription plan in payment provider.
     *
     * @return mixed
     */
    public function createPlan(PlanData $plan);
}
