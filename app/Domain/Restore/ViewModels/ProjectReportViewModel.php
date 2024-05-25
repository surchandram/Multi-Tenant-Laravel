<?php

namespace SAAS\Domain\Restore\ViewModels;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapReadingData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\DataTransferObjects\StructureMoistureData;
use SAAS\Domain\Restore\Models\Project;

class ProjectReportViewModel extends ViewModel
{
    use ProjectsShareableTrait;

    public function __construct(
        public readonly ?Project $project,
        public readonly ?Request $request = null,
    ) {
        $this->project->loadMissing([
            'status',
            'type',
            'class',
            'category',
            'team',
            'address.country',
            'owner.address.country',
            'affectedAreas.affectedArea',
        ]);

        $this->request->collect('setup')->each(function ($key) {
            $this->project->loadMissing([
                'insurance.adjuster',
                'insurance.agent',
                'insurance.company',
            ]);

            if ($key == 'moisture_map') {
                $this->project->loadMissing([
                    'moistureMap.affectedArea.affectedArea',
                    'moistureMap.material',
                    'moistureMap.structure',
                    'moistureMap.device',
                    'moistureMap.readings',
                ]);
            }

            if ($key == 'psychrometric_report') {
                $this->project->loadMissing([
                    'psychrometricReports.affectedArea.affectedArea',
                    'psychrometricReports.psychrometryMeasurePoint',
                ]);
            }

            if ($key == 'documents') {
                $this->project->loadMissing([
                    'documents.type',
                ]);
            }

            if ($key == 'logs') {
                $this->project->loadMissing([
                    'logs',
                ]);
            }
        });
    }

    public function visibleData()
    {
        $visible = [];

        $config = array_keys(ProjectData::reportSetupMap());

        foreach ($config as $key) {
            $visible[$key] = in_array($key, $this->request->query('setup'));
        }

        return $visible;
    }

    public function company()
    {
        $tenant = request()->tenant();

        tenancy()->runNonTenantTask(function () use (&$tenant) {
            $tenant->loadMissing([
                'addresses.country',
                'media',
            ]);
        });

        return CompanyData::fromModel($tenant);
    }

    public function psychrometryMeasurePoints()
    {
        return [
            'temperature' => 'Temp',
            'relative_humidity' => 'RH %',
            'grain_per_pound' => 'GPP',
            'dew_point' => 'Dew',
        ];
    }

    public function logs()
    {
        if (! in_array('logs', $this->request->get('setup'))) {
            return [];
        }

        return $this->project->logs->groupBy(fn ($log) => $log->created_at->toDateString());
    }

    public function psychrometricReport()
    {
        if (! in_array('psychrometric_report', $this->request->get('setup'))) {
            return [];
        }

        return $this->project->psychrometricReports->areaBasedTree();
    }

    public function moistureMap()
    {
        if (! in_array('moisture_map', $this->request->get('setup'))) {
            return [];
        }

        return ProjectData::fromModel($this->project)
            ->moistureMap
            ->toCollection()
            ->map(
                fn (StructureMoistureData $data, $key) => [
                    'id' => $data->id,
                    'affected_area' => $data->affectedArea->affectedArea->name,
                    'affected_area_id' => $data->affectedArea->affectedArea->id,
                    'project_affected_area_id' => $data->affectedArea->id,
                    'structure' => $data->structure->name,
                    'material' => $data->material->name,
                    'dry_goal' => $data->material->dry_goal,
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
            });
    }

    public function projectAddress()
    {
        $project = $this->project->owner->address ?? $this->project->address;

        return AddressData::from($project);
    }

    protected function formatDocumentBody($document)
    {
        $replacements = $this->replacements();
        $document->body = str($document->body)->replace(
            array_keys($replacements),
            array_values($replacements)
        );

        return $document;
    }

    private function replacements()
    {
        return [
            '%company%' => __('Company (:name)', ['name' => request()->tenant()->name]),
            '%owner_name%' => $this->project->owner?->name,
            '%job_address%' => $this->project->address?->formatted_address,
            '%insurance_company%' => $this->project->insurance?->name,
            '%company_name%' => __('Company name (:name)', ['name' => request()->tenant()->name]),
            '%date_of_loss%' => $this->project->loss_occurred_at->copy()->toFormattedDateString(),
        ];
    }

    public function project()
    {
        $project = $this->project;

        $project->documents->map(
            fn ($document) => $this->formatDocumentBody($document)
        );

        return $projectData = ProjectData::fromModel($project)->additional([
            'created_at' => $project->created_at->toFormattedDateString(),
            'contacted_at' => $project->contacted_at->toFormattedDateString(),
            'starts_at' => $project->starts_at->toFormattedDateString(),
            'loss_occurred_at' => $project->loss_occurred_at->toFormattedDateString(),
            'ends_at' => $project->ends_at->toFormattedDateString(),
        ]);
    }
}
