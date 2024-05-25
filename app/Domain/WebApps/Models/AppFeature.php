<?php

namespace SAAS\Domain\WebApps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SAAS\App\Support\Traits\Eloquent\CanBeDefault;
use SAAS\Domain\Features\Models\Feature;

class AppFeature extends Model
{
    use HasFactory,
        CanBeDefault;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'feature_id',
        'limit',
        'is_unlimited',
        'default',
    ];

    /**
     * Change the default app feature to 'false'.
     *
     * @return void
     */
    public function changeDefaultsForModel()
    {
        $this->app->features()->update([
            'default' => false,
        ]);
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
     * Get app that owns feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
