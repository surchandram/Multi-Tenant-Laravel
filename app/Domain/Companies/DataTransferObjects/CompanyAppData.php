<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Models\CompanyApp;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class CompanyAppData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|CompanyData $company,
        public readonly null|Lazy|AppData $app,
        public readonly ?array $data,
        public readonly ?string $setup_at,
        public readonly ?string $last_patched_at,
        public readonly ?string $created_at,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'app' => AppData::optional(
                App::find($request->validated('app_id'))
            ),
            'company' => CompanyData::optional(
                Company::find($request->validated('company_id'))
            ),
        ]);
    }

    public static function fromModel(CompanyApp $companyApp)
    {
        return self::from([
            ...$companyApp->toArray(),
            'app' => Lazy::whenLoaded(
                'app',
                $companyApp,
                fn () => AppData::fromModel($companyApp->app),
            ),
        ]);
    }
}
