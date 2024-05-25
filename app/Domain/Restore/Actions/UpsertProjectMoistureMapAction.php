<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapData;
use SAAS\Domain\Restore\DataTransferObjects\StructureMoistureData;
use SAAS\Domain\Restore\Models\Material;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\Structure;

class UpsertProjectMoistureMapAction
{
    public static function execute(MoistureMapData $moistureMapData, Project $project): Project
    {
        try {
            DB::transaction(function () use ($moistureMapData) {
                // moistureMap
                $moistureMap = $moistureMapData->mappedAreas->toCollection()->map(function (StructureMoistureData $structureMoistureData) use ($moistureMapData) {
                    // find or create structure
                    $structure = Structure::firstOrCreate(
                        $structureMoistureData->structure->only('name')->all()
                    )->id;

                    // find or create material
                    $material = Material::firstOrCreate(
                        $structureMoistureData->material->only('name')->all()
                    )->id;

                    // update or create moisture map for structure
                    $model = MoistureMap::updateOrCreate([
                        'project_id' => $moistureMapData->project->id,
                        'project_affected_area_id' => $structureMoistureData->affectedArea->id,
                        'structure_id' => $structure,
                        'material_id' => $material,
                        // device_id,
                    ]);

                    return $model;
                });

                return $moistureMap;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project;
    }
}
