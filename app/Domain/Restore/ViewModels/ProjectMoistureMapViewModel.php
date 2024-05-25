<?php

namespace SAAS\Domain\Restore\ViewModels;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\MaterialData;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapReadingData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\DataTransferObjects\StructureData;
use SAAS\Domain\Restore\DataTransferObjects\StructureMoistureData;
use SAAS\Domain\Restore\Models\Material;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\Structure;

class ProjectMoistureMapViewModel extends ViewModel
{
    use ProjectsShareableTrait;

    public function __construct(
        public readonly ?Project $project,
        public readonly ?Request $request = null,
    ) {
    }

    public function structures()
    {
        return StructureData::collection(
            Structure::get()
        );
    }

    public function materials()
    {
        return MaterialData::collection(
            Material::get()
        );
    }

    public function project()
    {
        $project = $this->project->load([
            'status',
            'address.country',
            'affectedAreas.affectedArea',
            'moistureMap.affectedArea.affectedArea',
            'moistureMap.material',
            'moistureMap.structure',
            'moistureMap.device',
            'moistureMap.readings',
        ]);

        return ($projectData = ProjectData::fromModel($project))->additional([
            'moisture_map' => $projectData->moistureMap->toCollection()
                ->map(
                    fn (StructureMoistureData $data) => [
                        'id' => $data->id,
                        'affected_area_id' => $data->affectedArea->affectedArea->id,
                        'structure' => $data->structure->name,
                        'material' => $data->material->name,
                        'device' => $data->device,
                        'readings' => $data->readings->toCollection()
                            ->mapWithKeys(
                                fn (MoistureMapReadingData $readingData) => [
                                    Carbon::parse($readingData->recorded_at)->format('Y-m-d H:m') => $readingData->value,
                                ]
                            ),
                    ]
                ),
            'moisture_summary' => $projectData->moistureMap->toCollection()
                ->map(
                    fn (StructureMoistureData $data, $key) => [
                        'id' => $data->id,
                        'affected_area' => $data->affectedArea->affectedArea->name,
                        'affected_area_id' => $data->affectedArea->affectedArea->id,
                        'project_affected_area_id' => $data->affectedArea->id,
                        'structure' => $data->structure->name,
                        'material' => $data->material->name,
                        'readings' => $data->readings->toCollection()
                            ->mapWithKeys(
                                fn (MoistureMapReadingData $readingData) => [
                                    Carbon::parse($readingData->recorded_at)->format('Y-m-d') => $readingData->value,
                                ]
                            ),
                        'readings_by_id' => $data->readings->toCollection()
                            ->mapWithKeys(
                                fn (MoistureMapReadingData $readingData) => [
                                    Carbon::parse($readingData->recorded_at)->format('Y-m-d') => $readingData->id,
                                ]
                            ),
                    ]
                )
                ->groupBy('affected_area')->map(function ($area) {
                    return $area->groupBy('structure');
                }),
        ]);
    }
}
