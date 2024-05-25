<?php

namespace SAAS\Domain\Pages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use SAAS\App\Pages\Traits\InteractsWithPageComponents;
use SAAS\App\Support\Traits\Eloquent\HasImages;
use SAAS\App\Support\Traits\Eloquent\HasLogo;
use SAAS\App\Support\Traits\Eloquent\IsUsable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use IsUsable;
    use InteractsWithMedia;
    use SoftDeletes;
    use HasImages;
    use NodeTrait;
    use HasLogo;
    use InteractsWithPageComponents;

    protected $fillable = [
        'uuid',
        'title',
        'uri',
        'name',
        'body',
        'usable',
        'hidden',
    ];

    protected $casts = [
        'usable' => 'boolean',
        'hidden' => 'boolean',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Register the conversions that should be performed.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media|null  $media
     * @return void
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(100)
            ->height(100)
            ->performOnCollections('main_image', 'images', 'logo');

        $this->addMediaConversion('small')
            ->width(368)
            ->height(232)
            ->performOnCollections('main_image', 'images', 'logo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
            ->singleFile();

        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
