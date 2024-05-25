<?php

namespace SAAS\Domain\Documents\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\IsUsable;
use SAAS\Domain\Documents\Filters\DocumentFilters;

class Document extends Model
{
    use ForTenants;
    use HasFactory;
    use IsUsable;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'usable',
        'is_editable',
        'document_type_id',
    ];

    protected $casts = [
        'usable' => 'boolean',
        'is_editable' => 'boolean',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Determine whether document is syncable.
     *
     **/
    public function shouldBeSynced(): bool
    {
        return \SAAS\Domain\Documents\Enums\DocumentType::forSync($this->type->slug);
    }

    /**
     * Determine whether document is editable.
     *
     **/
    public function isEditable(): bool
    {
        return $this->is_editable == true;
    }

    /**
     * Scope a query to include only "records" that match passed filters.
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new DocumentFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Scope query to include only documents that match set 'type'.
     */
    public function scopeWhereTypes(Builder $builder, $slugs = [])
    {
        return $builder->whereHas('type', fn ($query) => $query->whereIn('slug', $slugs));
    }

    /**
     * Get document type classification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id', 'id');
    }
}
