<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Tenant\Actions\UpsertPersonAction;

class CreateProjectAction
{
    public static function execute(ProjectData $projectData): Project
    {
        try {
            $project = DB::transaction(function () use ($projectData) {
                if ($projectData->owner) {
                    $person = UpsertPersonAction::execute(
                        $projectData->owner
                    );

                    // create or update address
                    if ($projectData->owner->address) {
                        $person->addAddress(
                            $projectData->owner->address->all(),
                        );
                    }
                }

                $data = $projectData->additional([
                    'team_id' => $projectData->team?->id,
                    'type_id' => $projectData->type?->id,
                    'class_id' => $projectData->class?->id,
                    'category_id' => $projectData->category?->id,
                    'owner_id' => isset($person) ? $person?->id : null,
                ]);

                $project = Project::create($data->all());

                // setup project affected areas
                if (filled($projectData->affectedAreas)) {
                    SyncProjectAffectedAreasAction::execute(
                        $projectData->affectedAreas,
                        $project
                    );
                }

                // setup insurance
                if (filled($projectData->insurance)) {
                    // setup insurance details
                    UpsertProjectInsuranceAction::execute(
                        $projectData->insurance,
                        $project
                    );
                }

                // create or update address
                if (filled($projectData->address)) {
                    $project->addOrUpdateAddress(
                        $projectData->address->all(),
                        $projectData->address->id ?? $project->address?->id
                    );
                }

                // attach or detach documents
                if (filled($projectData->documents) && $projectData->documents->count()) {
                    // sync documents to project
                    $project->documents()->syncWithoutDetaching(
                        $projectData->documents->toCollection()->pluck('id')
                    );
                }

                return $project;
            });
        } catch (\Exception $e) {
            Log::error('Failed creating project.', [$e]);

            throw $e;
        }

        return $project;
    }
}
