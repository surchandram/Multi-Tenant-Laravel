<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectStatusData;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Events\Projects\ProjectApprovedEvent;
use SAAS\Domain\Restore\Models\Project;

class AuthorizeProjectAction
{
    /**
     * Authorize project.
     */
    public static function execute(array $signedDocuments, Project $project, Company $company): Project
    {
        try {
            DB::transaction(function () use ($signedDocuments, $project, $company) {
                $data = static::prepareDocuments($signedDocuments);

                $syncedData = $data->toCollection()->mapWithKeys(fn ($doc) => [
                    $doc->id => [
                        'signature' => $doc->signature,
                    ],
                ]);

                // attach signature to project documents
                $project->documents()->syncWithoutDetaching($syncedData);

                // update project
                $project->update([
                    'status_id' => ProjectStatusData::fromEnum(
                        ProjectStatuses::Approved
                    )->id,
                ]);

                // fire event
                event(new ProjectApprovedEvent($project, $company));

                return $project;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project->refresh();
    }

    private static function prepareDocuments($signedDocuments)
    {
        $data = DocumentData::collection(
            collect(
                collect($signedDocuments)->map(
                    fn ($a) => DocumentData::fromSignature(
                        $a['document_id'],
                        $a['signature']
                    )
                )
            )
        );

        return $data;
    }
}
