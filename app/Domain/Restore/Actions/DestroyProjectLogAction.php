<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Restore\Models\ProjectLog;

class DestroyProjectLogAction
{
    public static function execute(ProjectLog $projectLog)
    {
        try {
            DB::transaction(function () use ($projectLog) {
                $projectLog->delete();
            });
        } catch (\Exception $exception) {
            Log::error('Failed deleting log from project.', [$exception]);

            throw $exception;
        }

        return true;
    }
}
