<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Features\Models\Feature;

trait InteractsWithFeatures
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootInteractsWithFeatures()
    {
        //
    }

    /**
     * The model class for the features relationship.
     *
     * @return string
     */
    abstract protected function featureModel();

    /**
     * Get a model's feature by 'key' column.
     *
     * @param  string  $key
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function feature($key)
    {
        return $this->features()->whereHas('feature', function ($query) use ($key) {
            $query->where('key', $key);
        })->first();
    }

    /**
     * Determine if model's has the given feature.
     *
     * @param  \SAAS\Domain\Features\Models\Feature  $feature
     * @return mixed
     */
    public function hasFeature(Feature $feature)
    {
        return $this->features->contains('feature_id', $feature->id);
    }

    /**
     * Scope query to include only `active` plan features.
     *
     * @param  Illuminate\Database\Eloquent\Builder  $builder
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithActiveFeatures(Builder $builder)
    {
        return $builder->with([
            'features.feature' => function ($query) {
                $query->active();
            },
        ]);
    }

    /**
     * Get all the plan's features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features()
    {
        return $this->hasMany($this->featureModel());
    }
}
