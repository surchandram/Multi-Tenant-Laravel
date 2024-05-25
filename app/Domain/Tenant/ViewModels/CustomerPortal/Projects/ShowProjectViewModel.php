<?php

namespace SAAS\Domain\Tenant\ViewModels\CustomerPortal\Projects;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Enums\DocumentType;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Models\Project;

class ShowProjectViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Project $project,
        public readonly ?Request $request = null,
    ) {
        $this->project->load([
            'status',
            'type',
            'class',
            'category',
            'team',
            'address.country',
            'owner.address.country',
            'insurance.adjuster',
            'insurance.agent',
            'insurance.company',
            'affectedAreas.affectedArea',
            'documents' => fn ($q) => $q->active()->orderBy('document_type_id', 'asc'),
            'documents.type',
            'user.media',
            'logs.user',
        ]);
    }

    /**
     * Determine if project's status priority is below or not set to 'approved'.
     */
    public function projectNotApproved(): bool
    {
        if ($this->project->currentStatus->is(ProjectStatuses::Pending)) {
            return true;
        }

        return $this->project->currentStatus->hasNoPriorityOver(ProjectStatuses::Approved);
    }

    public function canAuthorizeCompletion()
    {
        return $this->project->currentStatus->is(ProjectStatuses::ApproveCompletion);
    }

    public function canAuthorizeStart()
    {
        return $this->project->currentStatus->is(ProjectStatuses::Pending);
    }

    public function completionDocument()
    {
        $document = $this->project->documents->where(function ($document) {
            return $document->type?->slug == DocumentType::WorkCompletion->value;
        })->first();

        if (! $document) {
            return [];
        }

        return DocumentData::fromModel($document);
    }

    public function authorizationDocuments()
    {
        $documents = $this->project->documents->where(function ($document) {
            return $document->type?->slug != DocumentType::WorkCompletion->value;
        })->values();

        if ($documents->count() < 1) {
            return [];
        }

        return DocumentData::collection($documents);
    }

    public function replacements()
    {
        return [
            'company%' => __('Company (:name)', ['name' => request()->tenant()->name]),
            'owner_name%' => $this->project->owner?->name,
            'job_address%' => $this->project->address?->formatted_address,
            'insurance_company%' => $this->project->insurance?->name,
            'company_name%' => __('Company name (:name)', ['name' => request()->tenant()->name]),
            'date_of_loss%' => $this->project->loss_occurred_at->copy()->toFormattedDateString(),
        ];
    }

    public function project()
    {
        return ProjectData::fromModel($this->project);
    }
}
