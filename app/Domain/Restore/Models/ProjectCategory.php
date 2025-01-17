<?php

namespace SAAS\Domain\Restore\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class ProjectCategory extends Model
{
    use ForTenants;
    use HasFactory;
    use Sluggable;
    use IsUsable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'usable',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
