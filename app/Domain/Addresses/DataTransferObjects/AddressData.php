<?php

namespace SAAS\Domain\Addresses\DataTransferObjects;

use SAAS\Domain\Addresses\Models\Address;
use SAAS\Domain\Countries\DataTransferObjects\CountryData;
use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $address_1,
        public readonly ?string $address_2,
        public readonly string $state,
        public readonly string $city,
        public readonly string $postal_code,
        public readonly ?string $formattedAddress,
        public readonly ?int $country_id,
        public readonly ?bool $default,
        public readonly ?bool $billing,
        public readonly ?CountryData $country,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            ...$address->toArray(),
            'formattedAddress' => $address->formattedAddress,
        ]);
    }
}
