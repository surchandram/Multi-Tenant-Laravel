<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property bool $overrideDefaults Set whether the trait default events should be skipped.
 */
trait CanBeDefault
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootCanBeDefault()
    {
        static::creating(function ($model) {
            if ($model->default && ! $model->overrideDefaults) {
                $model->changeDefaultsForModel();
            }
        });

        static::updating(function ($model) {
            if ($model->default && ! $model->overrideDefaults) {
                $model->changeDefaultsForModel();
            }
        });
    }

    /**
     * Define how defaults should be switched in model.
     *
     * @return void
     */
    abstract public function changeDefaultsForModel();

    /**
     * Sets the 'default' attribute correct value.
     *
     * @param $value
     * @return void
     */
    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }

    /**
     * Determine if model is the 'default'.
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * Scope query to include only `default` records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  bool  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefault(Builder $builder, $value = true)
    {
        return $builder->where('default', $value);
    }

    /**
     * Scope query to exclude `default` records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDefault(Builder $builder)
    {
        return $this->scopeDefault($builder, false);
    }
}
