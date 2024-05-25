<?php

namespace SAAS\App\Payments;

use SAAS\Domain\Payments\Models\PaymentMethod;

interface GatewayCustomer
{
    /**
     * @param  int|\SAAS\App\Support\Money  $amount
     * @return mixed
     */
    public function charge(PaymentMethod $paymentMethod, $amount);

    public function addCard($token);
}
