<?php

namespace SAAS\Domain\Restore\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Countries\DataTransferObjects\CountryData;
use SAAS\Domain\Countries\Models\Country;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;
use SAAS\Domain\Restore\DataTransferObjects\AffectedAreaData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectCategoryData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectClassData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectTypeData;
use SAAS\Domain\Restore\Models\AffectedArea;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectCategory;
use SAAS\Domain\Restore\Models\ProjectClass;
use SAAS\Domain\Restore\Models\ProjectType;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Tenant\DataTransferObjects\OrganizationData;
use SAAS\Domain\Tenant\Enums\OrganizationType;
use SAAS\Domain\Tenant\Models\Organization;

class ProjectCreateViewModel extends ViewModel
{
    use ProjectsShareableTrait;

    public function __construct(
        public readonly ?Project $project = null,
        public readonly ?Request $request = null,
    ) {
    }

    public function teams()
    {
        return TeamData::collection(
            request()
                ->tenant()
                ->teams()
                ->with(['users.media'])
                ->active()
                ->get()
        );
    }

    public function allowedDocuments()
    {
        return DocumentData::collection(
            Document::with([
                'type',
            ])->whereTypes(
                array_keys(ProjectData::allowedDocumentsMap())
            )->active()->get()
        )->toCollection()->groupBy(fn ($document) => $document->toArray()['type']['slug']);
    }

    public function allowedProjectDocuments()
    {
        return ProjectData::allowedDocumentsMap();
    }

    public function replacements()
    {
        return [
            'company%' => __('Company (:name)', ['name' => config('app.name')]),
            'owner_name%' => 'Jane Doe',
            'job_address%' => '123 ABC Street, ABC City, ABC',
            'insurance_company%' => 'ABC Insurance',
            'company_name%' => __('Company name (:name)', ['name' => config('app.name')]),
            'date_of_loss%' => now()->copy()->subDays(3)->toFormattedDateString(),
        ];
    }

    public function affectedAreas()
    {
        return AffectedAreaData::collection(
            AffectedArea::active()->get()
        );
    }

    public function insuranceCompanies()
    {
        return OrganizationData::collection(
            Organization::with([
                'users.person',
            ])->whereHas(
                'type', fn ($query) => $query->whereSlug(OrganizationType::Insurance->value)
            )->get()
        );
    }

    public function types()
    {
        return ProjectTypeData::collection(ProjectType::active()->get());
    }

    public function categories()
    {
        return ProjectCategoryData::collection(ProjectCategory::active()->get());
    }

    public function classes()
    {
        return ProjectClassData::collection(ProjectClass::active()->get());
    }

    public function countries()
    {
        return CountryData::collection(Country::get());
    }
}
