<?php

namespace SAAS\Domain\Companies\Actions;

use SAAS\Domain\Companies\Models\Company;
use Stripe\Account;

class CreateCompanyStripeAccountAction
{
    public static function execute(Company $company): Account
    {
        $response = app('stripe')->accounts->create(['type' => Account::TYPE_STANDARD]);

        $company->update([
            'stripe_account_id' => $response->id,
        ]);

        return $response;
    }
}
