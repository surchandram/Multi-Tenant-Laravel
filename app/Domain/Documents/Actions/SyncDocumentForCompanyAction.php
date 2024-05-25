<?php

namespace SAAS\Domain\Documents\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;

class SyncDocumentForCompanyAction
{
    public static function execute(DocumentData $documentData, Document $document = null): Document
    {
        try {
            $model = DB::transaction(function () use ($documentData, $document) {
                $data = [
                    'title' => $documentData->title,
                    'body' => $documentData->body,
                ];

                if ($document) {
                    $document->update($data);

                    return $document->refresh();
                } else {
                    return Document::updateOrCreate([
                        'title' => $documentData->title,
                        'document_type_id' => $documentData->type?->id,
                        'is_editable' => $documentData->is_editable ?? false,
                    ], [
                        ...$data,
                        'is_editable' => $documentData->is_editable ?? false,
                        'usable' => $documentData->usable,
                        'document_type_id' => $documentData->type?->id,
                    ]);
                }
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
