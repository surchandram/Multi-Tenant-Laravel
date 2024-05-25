<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Restore\DataTransferObjects\ProjectLogData;
use SAAS\Domain\Restore\Models\ProjectLog;

class UpdateProjectLogAction
{
    public static function execute(ProjectLogData $projectLogData, ProjectLog $log)
    {
        try {
            DB::transaction(function () use ($projectLogData, $log) {
                return $log->update([
                    'body' => $projectLogData->body,
                ]);
            });
        } catch (\Exception $exception) {
            Log::error('Failed updating project log.', [$exception]);

            throw $exception;
        }

        return $log->fresh();
    }
}
