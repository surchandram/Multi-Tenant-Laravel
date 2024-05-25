<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\WebApps\Models\App;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class CompanyData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $uuid,
        public string $name,
        public ?string $email,
        public ?string $domain,
        public ?string $measurement_unit,
        public ?string $currency,
        public ?string $default_tax,
        public ?string $license_no,
        public ?string $tax_id,
        public ?string $projects_prefix,
        public ?bool $personal_team,
        public ?string $created_at,
        public ?int $users_count,
        public readonly null|Lazy|string|UploadedFile $logo,
        public ?bool $has_subscription,
        public ?bool $has_active_subscription,
        public ?array $data,
        public null|Lazy|PlanData $subscription_plan,
        public null|Lazy|AddressData $address,
        /**
         * @var DataCollection<UserData>
         */
        public null|Lazy|DataCollection $users,
        /**
         * @var DataCollection<CompanyAppData>
         */
        public null|Lazy|DataCollection $apps,
    ) {
    }

    public static function fromModel(Company $company)
    {
        return self::from([
            ...$company->toArray(),
            'has_subscription' => $company->hasSubscription(),
            'has_active_subscription' => $company->hasNotCancelled(),
            'subscription_plan' => $company->hasNoSubscription() ? null : Lazy::whenLoaded(
                'plans',
                $company,
                fn () => PlanData::fromModel($company->plan)
            ),
            'address' => Lazy::whenLoaded(
                'addresses',
                $company,
                fn () => filled($company->address) ? AddressData::fromModel($company->address) : AddressData::optional()
            ),
            'users' => Lazy::whenLoaded(
                'users',
                $company,
                fn () => UserData::collection($company->users)
            ),
            'apps' => Lazy::whenLoaded(
                'apps',
                $company,
                fn () => CompanyAppData::collection($company->apps)
            ),
        ]);
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
            'personal_team' => $request->validated('personal_team') ?? false,
            'apps' => ! filled($request->validated('apps')) ? null : CompanyAppData::collection(
                collect($request->validated('apps'))->map(fn ($data) => [
                    'app' => App::find($data['app_id']),
                    'data' => $data['data'] ?? [],
                ])
            ),
        ]);
    }
}
