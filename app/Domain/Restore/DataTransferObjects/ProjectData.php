<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectCategory;
use SAAS\Domain\Restore\Models\ProjectClass;
use SAAS\Domain\Restore\Models\ProjectType;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Models\Team;
use SAAS\Domain\Tenant\DataTransferObjects\PersonData;
use SAAS\Domain\Threads\DataTransferObjects\ThreadData;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class ProjectData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $uuid,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $overview,
        public readonly null|Lazy|ProjectTypeData $type,
        public readonly null|Lazy|ProjectClassData $class,
        public readonly null|Lazy|ProjectCategoryData $category,
        public readonly null|Lazy|TeamData $team,
        public readonly null|Lazy|PersonData $owner,
        public readonly null|Lazy|InsuranceData $insurance,
        public readonly null|Lazy|ProjectStatusData $status,
        public readonly ?string $point_of_loss,
        public readonly ?string $loss_occurred_at,
        public readonly ?string $contacted_at,
        public readonly ?string $starts_at,
        public readonly ?string $ends_at,
        public readonly ?string $created_at,
        public readonly ?bool $usable,
        public readonly ?bool $not_approved,
        public readonly ?int $affected_areas_count,
        public readonly null|Lazy|UserData $user,
        public readonly null|Lazy|AddressData $address,
        /** @var DataCollection<AffectedAreaData> */
        public readonly null|Lazy|DataCollection $affectedAreas,
        /** @var DataCollection<StructureMoistureData> */
        public readonly null|Lazy|DataCollection $moistureMap,
        /** @var DataCollection<DocumentData> */
        public readonly null|Lazy|DataCollection $documents,
        /** @var DataCollection<ProjectLogData> */
        public readonly null|Lazy|DataCollection $logs,
        public readonly null|Lazy|ThreadData $thread,
    ) {
    }

    public static function fromId(int $id)
    {
        return self::fromModel(Project::find($id));
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'type' => ProjectTypeData::from(ProjectType::findOrNew($request->type_id)),
            'class' => ProjectClassData::from(ProjectClass::findOrNew($request->class_id)),
            'category' => ProjectCategoryData::from(ProjectCategory::findOrNew($request->category_id)),
            'team' => $request->validated('team_id') ?
                TeamData::from(
                    Team::find($request->validated('team_id'))
                ) : null,
            'affectedAreas' => $request->validated('affected_areas') ? AffectedAreaData::collection(
                $request->validated('affected_areas')
            ) : null,
            'documents' => DocumentData::collection(
                Document::with('type')->whereIn('id', Arr::wrap($request->validated('documents')))->get()
            ),
        ]);
    }

    public static function fromModel(Project $project): self
    {
        return self::from([
            ...$project->toArray(),
            'not_approved' => $project->currentStatus?->hasNoPriorityOver(ProjectStatuses::Approved),
            'type' => Lazy::whenLoaded(
                'type',
                $project,
                fn () => ProjectTypeData::from($project->type)
            ),
            'class' => Lazy::whenLoaded(
                'class',
                $project,
                fn () => ProjectClassData::from($project->class)
            ),
            'category' => Lazy::whenLoaded(
                'category',
                $project,
                fn () => ProjectCategoryData::from($project->category)
            ),
            'status' => Lazy::whenLoaded(
                'status',
                $project,
                fn () => ProjectStatusData::from($project->status)
            ),
            'address' => Lazy::whenLoaded(
                'address',
                $project,
                fn () => ProjectAddressData::from($project->address)
            ),
            'owner' => Lazy::whenLoaded(
                'owner',
                $project,
                fn () => PersonData::from($project->owner)
            ),
            'user' => Lazy::whenLoaded(
                'user',
                $project,
                fn () => UserData::from($project->user)
            ),
            'team' => Lazy::whenLoaded(
                'team',
                $project,
                fn () => TeamData::from($project->team)
            ),
            'insurance' => Lazy::whenLoaded(
                'insurance',
                $project,
                fn () => InsuranceData::fromModel($project->insurance)
            ),
            'affectedAreas' => Lazy::whenLoaded(
                'affectedAreas',
                $project,
                fn () => AffectedAreaData::collection(
                    $project->affectedAreas
                )
            ),
            'moistureMap' => Lazy::whenLoaded(
                'moistureMap',
                $project,
                fn () => StructureMoistureData::collection(
                    $project->moistureMap
                )
            ),
            'documents' => Lazy::whenLoaded(
                'documents',
                $project,
                fn () => DocumentData::collection(
                    $project->documents
                )
            ),
            'logs' => Lazy::whenLoaded(
                'logs',
                $project,
                fn () => ProjectLogData::collection(
                    $project->logs
                )
            ),
            'thread' => Lazy::whenLoaded(
                'thread',
                $project,
                fn () => ThreadData::fromModel(
                    $project->thread
                )
            ),
        ]);
    }

    public static function reportSetupMap()
    {
        return [
            'moisture_map' => 'Moisture Map',
            'psychrometric_report' => 'Psychrometric Report',
            'documents' => 'Documents',
            'insurance_summary' => 'Insurance Summary',
            'insurance_company' => 'Insurance Company',
            'insurance_adjuster' => 'Insurance Adjuster',
            'insurance_agent' => 'Insurance Agent',
            'logs' => 'Daily Logs',
        ];
    }

    public static function allowedDocumentsMap()
    {
        $allowed = [
            \SAAS\Domain\Documents\Enums\DocumentType::WorkAuthorization->value,
            \SAAS\Domain\Documents\Enums\DocumentType::WorkCompletion->value,
            \SAAS\Domain\Documents\Enums\DocumentType::RealeaseFromLiability->value,
            \SAAS\Domain\Documents\Enums\DocumentType::ChemicalRealease->value,
        ];

        $data = [];

        foreach ($allowed as $value) {
            if ($type = \SAAS\Domain\Documents\Enums\DocumentType::tryFrom($value)) {
                $data[$value] = $type->label();
            }
        }

        return $data;
    }
}
