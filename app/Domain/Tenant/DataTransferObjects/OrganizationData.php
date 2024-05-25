<?php

namespace SAAS\Domain\Tenant\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class OrganizationData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly null|Lazy|OrganizationTypeData $type,
        #[DataCollectionOf(PersonData::class)]
        public readonly null|Lazy|DataCollection $users,
    ) {
    }
}
