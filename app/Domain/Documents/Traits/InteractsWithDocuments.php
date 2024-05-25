<?php

namespace SAAS\Domain\Documents\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use SAAS\Domain\Documents\Models\Document;

trait InteractsWithDocuments
{
    /**
     * Boot `InteractsWithDocuments` trait.
     */
    public static function bootInteractsWithDocuments(): void
    {
        //
    }

    /**
     * Updates the document to be attached to model.
     *
     * @param  array|\Illuminate\Support\Collection  $ids
     **/
    public function syncDocuments($ids): bool
    {
        if ($ids instanceof \Illuminate\Database\Eloquent\Collection) {
            $parsedIds = $ids->pluck('id', 'document_type_id');
        } elseif ($ids instanceof Collection) {
            $parsedIds = $ids->pluck('id', 'type.id');
        } else {
            $parsedIds = Document::whereIn('id', Arr::where($ids, fn ($value) => is_numeric($value)))
                ->get()
                ->pluck('id', 'document_type_id');
        }

        $changes = $this->documents()->sync($parsedIds);

        if (
            count($changes['attached']) ||
            count($changes['updated']) ||
            count($changes['detached'])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get all the documents owned by model.
     *
     **/
    public function documents(): MorphToMany
    {
        return $this->morphToMany(Document::class, 'documentable')->withPivot([
            'signature',
        ])->withTimestamps();
    }
}
