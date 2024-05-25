<?php

namespace SAAS\Domain\Countries\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class Country extends Model
{
    use IsUsable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dial_code',
        'code',
        'usable',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'usable' => 'boolean',
    ];

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return env('DB_CONNECTION');
    }
}
