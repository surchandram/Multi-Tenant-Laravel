<?php

namespace SAAS\Domain\Plans\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SAAS\App\Support\Traits\Eloquent\CanBeDefault;

class PlanApp extends Model
{
    use HasFactory,
        CanBeDefault,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'app_id',
        'limit',
        'is_unlimited',
        'default',
    ];

    /**
     * Change the default plan app to 'false'.
     *
     * @return void
     */
    public function changeDefaultsForModel()
    {
        $this->plan->apps()->update([
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
        return $this->app->name;
    }

    /**
     * Get associated app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(Feature::class);
    }

    /**
     * Get plan that owns app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
