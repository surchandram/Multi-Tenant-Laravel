<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Restore\Models\Project;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class ProjectReportData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|ProjectData $project,
    ) {
    }

    public static function fromId(int $id)
    {
        return self::fromModel(Project::find($id));
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'project' => ProjectData::from(Project::find($request->project)),
        ]);
    }

    public static function fromModel(Project $project): self
    {
        return self::from([
            'project' => ProjectData::from($project),
        ]);
    }
}
