<?php

namespace SAAS\Domain\Users\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Miracuthbert\LaravelRoles\Models\Role as BaseRole;
use SAAS\Domain\Users\Scopes\ScopesForRoles;

class Role extends BaseRole
{
    use ScopesForRoles;
    use Sluggable;

    protected $routeBySlug = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'usable',
        'parent_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['parent.name', 'name'],
            ],
        ];
    }

    /**
     * Get the model's breadcrumb name.
     *
     * @return mixed
     */
    public function breadcrumbName()
    {
        return $this->name;
    }
}
