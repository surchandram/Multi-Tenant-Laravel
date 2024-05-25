<?php

namespace SAAS\Domain\Devices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class Device extends Model
{
    use ForTenants;
    use HasFactory;
    use IsUsable;

    protected $fillable = [
        'name',
        'description',
        'usable',
        'type_id',
    ];

    protected $casts = [
        'usable' => 'boolean',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Get the type that the project belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DeviceType::class, 'type_id', 'id');
    }
}
