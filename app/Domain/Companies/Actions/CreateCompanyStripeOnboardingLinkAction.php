<?php

namespace SAAS\Domain\Companies\Actions;

use SAAS\Domain\Companies\Models\Company;
use Stripe\AccountLink;

class CreateCompanyStripeOnboardingLinkAction
{
    public static function execute(Company $company, string $refreshUrl, string $returnUrl): AccountLink
    {
        $response = app('stripe')->accountLinks->create([
            'account' => $company->ensureStripeConnectAccountCreated(),
            'type' => 'account_onboarding',
            'refresh_url' => $refreshUrl,
            'return_url' => $returnUrl,
        ]);

        return $response;
    }
}
