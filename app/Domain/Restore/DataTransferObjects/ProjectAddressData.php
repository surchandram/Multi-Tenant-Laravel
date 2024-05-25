<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use SAAS\Domain\Countries\DataTransferObjects\CountryData;
use Spatie\LaravelData\Data;

class ProjectAddressData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $address_1,
        public readonly ?string $address_2,
        public readonly string $state,
        public readonly string $city,
        public readonly string $postal_code,
        public readonly ?int $country_id,
        public readonly ?CountryData $country,
    ) {
    }
}
