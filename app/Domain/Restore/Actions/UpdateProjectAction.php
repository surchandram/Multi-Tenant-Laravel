<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Tenant\Actions\UpsertPersonAction;

class UpdateProjectAction
{
    public static function execute(ProjectData $projectData, Project $project): Project
    {
        try {
            /* @var Project $project */
            DB::transaction(function () use ($projectData, &$project) {
                // create or update owner details
                if ($projectData->owner) {
                    $person = UpsertPersonAction::execute(
                        $projectData->owner
                    );

                    // create or update address
                    if (filled($projectData->owner->address)) {
                        $person->addOrUpdateAddress(
                            $projectData->owner->address->all(),
                            $projectData->owner->address->id
                        );
                    }
                }

                // setup project affected areas
                if ($projectData->affectedAreas) {
                    SyncProjectAffectedAreasAction::execute(
                        $projectData->affectedAreas,
                        $project
                    );
                }

                // setup insurance
                if ($projectData->insurance) {
                    // setup insurance details
                    UpsertProjectInsuranceAction::execute(
                        $projectData->insurance,
                        $project
                    );
                }

                $data = $projectData->additional([
                    'team_id' => $projectData->team?->id,
                    'type_id' => $projectData->type?->id,
                    'class_id' => $projectData->class?->id,
                    'category_id' => $projectData->category?->id,
                    'owner_id' => $person?->id,
                ]);

                // update project
                $project->update(
                    $data->except('uuid', 'slug')->all()
                );

                // create or update address
                if ($projectData->address) {
                    $project->addOrUpdateAddress(
                        $projectData->address->all(),
                        $projectData->address->id ?? $project->address?->id
                    );
                }

                // attach or detach documents
                if ($projectData->documents->count()) {
                    // find documents no longer attached to project
                    $toBeDetached = collect($project->documents)->reject(
                        fn ($document) => Arr::where(
                            $projectData->documents->toArray(),
                            fn ($documentData) => $documentData['id'] === $document->id
                        )
                    );

                    if (count($toBeDetached) > 0) {
                        $project->documents()->detach($toBeDetached->pluck('id'));
                    }

                    // sync documents to project
                    $project->documents()->syncWithoutDetaching(
                        $projectData->documents->toCollection()->pluck('id')
                    );
                }

                return $project;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project;
    }
}
