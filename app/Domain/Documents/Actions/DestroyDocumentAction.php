<?php

namespace SAAS\Domain\Documents\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Documents\Models\Document;

class DestroyDocumentAction
{
    public static function execute(Document $document): ?bool
    {
        try {
            $deleted = DB::transaction(function () use ($document) {
                return $document->delete();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $deleted;
    }
}
