<?php

namespace SAAS\Domain\Companies\Actions;

use SAAS\Domain\Companies\Models\Company;

class VerifyCompanyStripeAccountAction
{
    public static function execute(Company $company): bool
    {
        $response = GetCompanyStripeAccountAction::execute($company);

        return $company->update([
            'stripe_account_enabled' => $response->payouts_enabled,
        ]);
    }
}
