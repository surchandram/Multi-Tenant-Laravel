<?php

namespace SAAS\Domain\Features\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class Feature extends Model
{
    use SoftDeletes,
        IsUsable,
        NodeTrait,
        HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key',
        'trial_limit',
        'is_unlimited',
        'description',
        'usable',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    public static function booting()
    {
        static::creating(function ($feature) {
            $feature->key = Str::snake($feature->key);
        });
    }

    /**
     * Get the owning addressable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function featurable()
    {
        return $this->morphTo();
    }
}
