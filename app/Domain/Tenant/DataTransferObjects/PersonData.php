<?php

namespace SAAS\Domain\Tenant\DataTransferObjects;

use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Tenant\Models\OrganizationUser;
use SAAS\Domain\Tenant\Models\Person;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PersonData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $role,
        public readonly null|Lazy|AddressData $address,
    ) {
    }

    public static function fromModel(Person $person)
    {
        return self::from([
            ...$person->toArray(),
        ]);
    }

    public static function fromOrganizationUser(OrganizationUser $organizationUser)
    {
        $organizationUser->person->role = $organizationUser->role;

        return self::fromModel($organizationUser->person);
    }
}
