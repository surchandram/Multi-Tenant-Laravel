<?php

namespace SAAS\Domain\Restore\ViewModels;

use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;

class ProjectEditViewModel extends ProjectCreateViewModel
{
    public function __construct(
        public readonly ?Project $project = null,
    ) {
        $this->project->loadMissing([
            'status',
            'type',
            'class',
            'category',
            'address.country',
            'owner.address.country',
            'team',
            'insurance.adjuster',
            'insurance.agent',
            'insurance.company',
            'affectedAreas.affectedArea',
            'documents.type',
        ]);
    }

    public function documents()
    {
        return DocumentData::collection(
            $this->project->documents
        )->toCollection()->reject(fn ($document) => ! filled($document->toArray()['type']))
            ->keyBy(fn ($document) => $document->toArray()['type']['slug']);
    }

    public function replacements()
    {
        return [
            'company%' => __('Company (:name)', ['name' => request()->tenant()->name]),
            'owner_name%' => $this->project->owner?->name,
            'job_address%' => $this->project->address?->formatted_address,
            'insurance_company%' => $this->project->insurance?->name,
            'company_name%' => __('Company name (:name)', ['name' => request()->tenant()->name]),
            'date_of_loss%' => $this->project->loss_occurred_at?->copy()->toFormattedDateString(),
        ];
    }

    public function project()
    {
        return ProjectData::fromModel($this->project)->additional([
            'type_id' => $this->project->type_id,
            'class_id' => $this->project->class_id,
            'category_id' => $this->project->category_id,
            'owner_id' => $this->project->owner_id,
            'team_id' => $this->project->team_id,
        ]);
    }
}
