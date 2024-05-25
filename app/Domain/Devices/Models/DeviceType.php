<?php

namespace SAAS\Domain\Devices\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class DeviceType extends Model
{
    use ForTenants;
    use HasFactory;
    use IsUsable;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'usable',
    ];

    protected $casts = [
        'usable' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '_',
            ],
        ];
    }
}
