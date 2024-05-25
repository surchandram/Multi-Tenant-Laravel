<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\AffectedAreaData;
use SAAS\Domain\Restore\Models\AffectedArea;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use Spatie\LaravelData\DataCollection;

class SyncProjectAffectedAreasAction
{
    /**
     * Store or update project's affected areas.
     *
     * @param  \Spatie\LaravelData\DataCollection<AffectedAreaData>  $affectedAreaData
     * @return \Illuminate\Support\Collection<ProjectAffectedArea>
     */
    public static function execute(DataCollection $affectedAreaData, Project $project): Collection
    {
        try {
            $projectAffectedArea = DB::transaction(function () use ($affectedAreaData, $project) {
                $affectedAreaData->each(function ($affectedArea) use ($project) {
                    $model = AffectedArea::firstOrCreate([
                        'name' => $affectedArea->name,
                    ]);

                    // create or update affected area
                    ProjectAffectedArea::updateOrCreate([
                        'affected_area_id' => $model->id,
                        'project_id' => $project->id,
                    ]);
                });

                $areas = $affectedAreaData->toCollection()->pluck('name')->all();

                // detach areas that are not present in current request
                $project->affectedAreas()->whereHas(
                    'affectedArea', fn ($query) => $query->whereNotIn('name', $areas)
                )->delete();

                return $project->affectedAreas;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $projectAffectedArea;
    }
}
