<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use SAAS\Domain\Restore\Models\ProjectInsurance;
use SAAS\Domain\Tenant\DataTransferObjects\OrganizationData;
use SAAS\Domain\Tenant\DataTransferObjects\PersonData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class InsuranceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|OrganizationData $company,
        public readonly null|Lazy|PersonData $agent,
        public readonly null|Lazy|PersonData $adjuster,
        public readonly ?string $claim_no,
        public readonly ?string $policy_no,
        public readonly ?int $deductible,
        public readonly ?string $formatted_deductible,
    ) {
    }

    public static function fromModel(ProjectInsurance $projectInsurance): self
    {
        return self::from([
            ...$projectInsurance->toArray(),
            'deductible' => (int) $projectInsurance->deductible->amount(),
            'formatted_deductible' => $projectInsurance->deductible->formatted(),
        ]);
    }
}
