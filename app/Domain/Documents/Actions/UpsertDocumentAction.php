<?php

namespace SAAS\Domain\Documents\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;

class UpsertDocumentAction
{
    public static function execute(DocumentData $documentData, Document $document = null): Document
    {
        try {
            $model = DB::transaction(function () use ($documentData, $document) {
                $data = [
                    'title' => $documentData->title,
                    'body' => $documentData->body,
                    'document_type_id' => $documentData->type == null ? null : $documentData->type?->id,
                    'usable' => $documentData->usable,
                    'is_editable' => $documentData->is_editable,
                ];

                if ($document) {
                    $document->update($data);

                    return $document->refresh();
                } else {
                    return Document::updateOrCreate([
                        'title' => $documentData->title,
                    ], $data);
                }
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
