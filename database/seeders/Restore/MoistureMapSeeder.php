<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapData;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapReadingData;
use SAAS\Domain\Restore\Models\AffectedArea;
use SAAS\Domain\Restore\Models\Material;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\MoistureMapReading;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use SAAS\Domain\Restore\Models\Structure;

class MoistureMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affectedAreaIds = AffectedArea::get()->pluck('id');
        $structureIds = Structure::get()->pluck('id');
        $materialIds = Material::get()->pluck('id');

        Project::query()->each(function (Project $project) use ($affectedAreaIds, $structureIds, $materialIds) {
            // setup moisture map
            if ($project->moistureMap->count() < 2) {
                for ($i = 0; $i < 2; $i++) {
                    $project->moistureMap()->create([
                        'project_affected_area_id' => ProjectAffectedArea::firstOrCreate([
                            'affected_area_id' => $affectedAreaIds->random(),
                            'project_id' => $project->id,
                        ])?->id,
                        'structure_id' => $structureIds->random(),
                        'material_id' => $materialIds->random(),
                    ]);
                }
            }

            if (! filled($project->starts_at)) {
                return;
            }

            if (! filled($project->ends_at)) {
                return;
            }

            $inspectionDates = [];

            $startedAt = $project->starts_at->copy();
            $inspectionDates[] = $startedAt->format('Y-m-d');

            do {
                $startedAt = $startedAt->copy()->addDay();
                $inspectionDates[] = $startedAt->copy()->format('Y-m-d');
            } while ($startedAt->lt($project->ends_at));

            foreach ($inspectionDates as $recordedAt) {
                $project->moistureMap()->each(function (MoistureMap $model) use ($recordedAt, $project) {
                    $moistureMap = MoistureMapData::from($model);

                    if ($model->readings->count()) {
                        $model->readings()->where('recorded_at', '<', $project->starts_at)
                            ->orWhere('recorded_at', '>', $project->ends_at)
                            ->delete();
                    }

                    $readings = MoistureMapReading::factory()->make([
                        'moisture_map_id' => $moistureMap->id,
                        'recorded_at' => $recordedAt,
                    ]);

                    $model->readings()->firstOrCreate([
                        'moisture_map_id' => $moistureMap->id,
                        'recorded_at' => $recordedAt,
                    ], ['value' => MoistureMapReadingData::fromModel($readings)->value]);
                });
            }
        });
    }
}
