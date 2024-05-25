<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Tenant\Models\Person;
use SAAS\Domain\Users\Models\User;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly ?string $name,
        public readonly string $email,
        public readonly string $username,
        public readonly ?string $phone,
        public readonly ?string $email_verified_at,
        public readonly ?string $created_at,
        public readonly ?string $deleted_at,
        public readonly ?bool $has_avatar,
        public readonly ?bool $two_factor_enabled,
        public readonly ?int $plans_count,
        public readonly ?int $companies_count,
        /** @var \Illuminate\Http\UploadedFile|string|\Spatie\MediaLibrary\Support\RemoteFile */
        public readonly mixed $avatar = null,
        /** @var DataCollection<CompanyData> */
        public readonly null|Lazy|DataCollection $companies,
        /** @var DataCollection<RoleData> */
        public readonly null|Lazy|DataCollection $roles,
    ) {
    }

    public static function fromProfileRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'id' => $request->user()->id,
        ]);
    }

    public static function fromPerson(Person $person)
    {
        return self::from([
            ...$person->only(['name', 'email', 'phone']),
            'first_name' => trim(($name = Str::of($person->name))->ucsplit()->first()),
            'last_name' => $name->ucsplit()->last(),
            'username' => $name->studly()->toString(),
        ]);
    }

    public static function fromModel(User $user)
    {
        return self::from([
            ...$user->toArray(),
            'name' => $user->name,
            'two_factor_enabled' => $user->hasEnabledTwoFactorAuthentication(),
            'companies' => Lazy::whenLoaded(
                'companies',
                $user,
                fn () => CompanyData::collection($user->companies)
            ),
            'roles' => Lazy::whenLoaded(
                'roles',
                $user,
                fn () => RoleData::collection($user->roles)
            ),
        ]);
    }
}
