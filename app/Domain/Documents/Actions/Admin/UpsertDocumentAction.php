<?php

namespace SAAS\Domain\Documents\Actions\Admin;

use SAAS\Domain\Companies\Actions\SyncDefaultDocumentsToCompaniesAction;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;

class UpsertDocumentAction
{
    public static function execute(DocumentData $documentData, Document $document = null): Document
    {
        try {
            $model = \SAAS\Domain\Documents\Actions\UpsertDocumentAction::execute($documentData, $document);

            // sync document to companies
            if (! $model->shouldBeSynced() && $model->usable) {
                SyncDefaultDocumentsToCompaniesAction::execute($model);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
