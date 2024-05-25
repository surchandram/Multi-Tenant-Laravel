<?php

namespace SAAS\Domain\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use SAAS\App\Support\Traits\Eloquent\CanBeDefault;
use SAAS\Domain\Features\Models\Feature;

class PlanFeature extends Model
{
    use CanBeDefault;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'feature_id',
        'limit',
        'is_unlimited',
        'default',
    ];

    /**
     * Change the default plan feature to 'false'.
     *
     * @return void
     */
    public function changeDefaultsForModel()
    {
        $this->plan->features()->update([
            'default' => false,
        ]);
    }

    /**
     * Get the model's breadcrumb name.
     *
     * @return mixed
     */
    public function breadcrumbName()
    {
        return $this->feature->name;
    }

    /**
     * Get associated feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    /**
     * Get plan that owns feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
