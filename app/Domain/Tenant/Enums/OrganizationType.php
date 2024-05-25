<?php

namespace SAAS\Domain\Tenant\Enums;

enum OrganizationType: string
{
    case Insurance = 'insurance';
    case HOA = 'hoa';

    public function label(): string
    {
        return match ($this) {
            static::Insurance => 'Insurance',
            static::HOA => 'HOA',
        };
    }
}
