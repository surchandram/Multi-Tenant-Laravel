<?php

namespace SAAS\Domain\Tenant\Enums;

enum OrganizationUserRole: string
{
    case InsuranceAgent = 'insurance_agent';
    case InsuranceAdjuster = 'insurance_adjuster';

    public function label(): string
    {
        return match ($this) {
            static::InsuranceAgent => 'insurance_agent',
            static::InsuranceAdjuster => 'insurance_adjuster',
        };
    }
}
