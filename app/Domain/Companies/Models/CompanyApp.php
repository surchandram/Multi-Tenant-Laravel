<?php

namespace SAAS\Domain\Companies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SAAS\Domain\WebApps\Models\App;

class CompanyApp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'app_id',
        'setup_at',
        'last_patched_at',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'setup_at' => 'datetime',
        'last_patched_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    public static function booting()
    {
        // static::creating(function($model) {
        //     $model->setup_at = now();
        //     $model->last_patched_at = null;
        // });
    }

    /**
     * Get company that owns app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the associated app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
