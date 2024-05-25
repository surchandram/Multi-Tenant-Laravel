<?php

namespace SAAS\Domain\Restore\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\IsUsable;

class ProjectStatus extends Model
{
    use ForTenants;
    use HasFactory;
    use NodeTrait;
    use Sluggable;
    use SluggableScopeHelpers;
    use IsUsable;

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::slugging(function ($model) {
            if ($model->slug) {
                // the model won't be slugged
                return false;
            }
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['parent.name', 'name'],
                'separator' => '_',
            ],
        ];
    }

    /**
     * Clone the model into a new, non-existing instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function replicate(array $except = null)
    {
        $defaults = [
            $this->getParentIdName(),
            $this->getLftName(),
            $this->getRgtName(),
        ];

        $except = $except ? array_unique(array_merge($except, $defaults)) : $defaults;

        $instance = parent::replicate($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }
}
