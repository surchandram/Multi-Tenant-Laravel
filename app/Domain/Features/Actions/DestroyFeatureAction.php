<?php

namespace SAAS\Domain\Features\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Features\Models\Feature;

class DestroyFeatureAction
{
    public static function execute(Feature $feature): bool
    {
        try {
            $deleted = DB::transaction(function () use ($feature) {
                // soft delete model
                return $feature->delete();
            });
        } catch (\Exception $e) {
            Log::error('Failed deleting feature.', [$e]);

            throw $e;
        }

        return $deleted;
    }
}
