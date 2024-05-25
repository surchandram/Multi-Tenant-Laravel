<?php

namespace SAAS\Domain\WebApps\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use SAAS\App\Support\Traits\Eloquent\HasLogo;
use SAAS\App\Support\Traits\Eloquent\InteractsWithFeatures;
use SAAS\App\Support\Traits\Eloquent\IsUsable;
use SAAS\Domain\Plans\Models\PlanApp;
use SAAS\Domain\WebApps\Filters\AppFilters;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class App extends Model implements HasMedia
{
    use HasFactory,
        IsUsable,
        InteractsWithFeatures,
        NodeTrait,
        InteractsWithMedia,
        HasLogo;

    protected $fillable = [
        'name',
        'key',
        'description',
        'url',
        'usable',
        'teams_only',
        'primary',
        'subscription',
    ];

    protected $casts = [
        'usable' => 'boolean',
        'teams_only' => 'boolean',
        'primary' => 'boolean',
        'subscription' => 'boolean',
    ];

    /**
     * The model class for the features relationship.
     *
     * @return string
     */
    protected function featureModel()
    {
        return AppFeature::class;
    }

    /**
     * Register the conversions that should be performed.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media|null  $media
     * @return void
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(100)
            ->height(100)
            ->performOnCollections('logo', 'images');

        $this->addMediaConversion('small')
            ->width(368)
            ->height(232)
            ->performOnCollections('logo', 'images');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    /**
     * Scope a query to include only "records" that match passed filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param $request
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new AppFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Get all plans associated with app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany(PlanApp::class);
    }
}
