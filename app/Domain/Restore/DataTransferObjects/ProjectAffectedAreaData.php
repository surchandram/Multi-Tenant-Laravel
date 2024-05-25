<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Restore\Models\AffectedArea;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class ProjectAffectedAreaData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|ProjectData $project,
        public readonly null|Lazy|AffectedAreaData $affectedArea,
    ) {
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(ProjectAffectedArea::find($id));
    }

    public static function fromModel(ProjectAffectedArea $projectAffectedArea): self
    {
        return self::from([
            ...$projectAffectedArea->toArray(),
            'project' => Lazy::whenLoaded(
                'project',
                $projectAffectedArea,
                fn () => ProjectData::from($projectAffectedArea->project)
            ),
            'affectedArea' => AffectedAreaData::from($projectAffectedArea->affectedArea),
        ]);
    }

    public static function fromRequest(Project $project, Request $request): self
    {
        return self::from([
            'id' => ProjectAffectedArea::where(
                'project_id',
                $project->id
            )->where(
                'affected_area_id',
                $request->affected_area_id,
            )->first()?->id,
            'project' => $project,
            'affectedArea' => AffectedAreaData::from(
                AffectedArea::find($request->affected_area_id)
            ),
        ]);
    }
}
