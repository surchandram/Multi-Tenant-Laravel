<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Users\Models\User;

class SetProjectUserAction
{
    public static function execute(Project $project, User $user): Project
    {
        try {
            DB::transaction(function () use ($project, $user) {
                $data = [
                    'user_id' => $user?->id,
                ];

                // update project
                $project->update($data);

                return $project;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project->refresh();
    }
}
