<?php

namespace SAAS\Domain\Companies\Actions;

use SAAS\Domain\Companies\Models\Company;
use Stripe\Account;

class GetCompanyStripeAccountAction
{
    public static function execute(Company $company): Account
    {
        return app('stripe')->accounts->retrieve($company->stripe_account_id, []);
    }
}
