<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Restore\DataTransferObjects\ProjectLogData;
use SAAS\Domain\Restore\Models\ProjectLog;

class CreateProjectLogAction
{
    public static function execute(ProjectLogData $projectLogData): ProjectLog
    {
        try {
            $projectLog = DB::transaction(function () use ($projectLogData) {
                return ProjectLog::create([
                    'body' => $projectLogData->body,
                    'project_id' => $projectLogData->project->id,
                    'user_id' => $projectLogData->user->id,
                ]);
            });
        } catch (\Exception $exception) {
            Log::error('Failed creating project log.', [$exception]);

            throw $exception;
        }

        return $projectLog;
    }
}
