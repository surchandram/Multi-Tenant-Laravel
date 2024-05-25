<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectLog;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\User;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class ProjectLogData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $body,
        public readonly null|Lazy|ProjectData $project,
        public readonly null|Lazy|UserData $user,
        public readonly ?string $created_at,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'project' => ProjectData::fromModel(
                Project::find($request->validated('project_id'))
            ),
            'user' => UserData::fromModel(
                User::find($request->validated('user_id'))
            ),
        ]);
    }

    public static function fromModel(ProjectLog $projectLog)
    {
        return self::from([
            ...$projectLog->toArray(),
        ]);
    }
}
