<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Spatie\Image\Manipulations;

trait HasAvatar
{
    /**
     * Boot 'HasAvatar' trait for a model.
     *
     * @return void
     */
    public static function bootHasAvatar()
    {
        //
    }

    /**
     * Initialize the 'HasAvatar' trait for an instance.
     *
     * @return void
     */
    public function initializeHasAvatar()
    {
        if (! in_array('has_avatar', $this->appends)) {
            $this->appends[] = 'has_avatar';
        }

        if (! in_array('avatar', $this->appends)) {
            $this->appends[] = 'avatar';
        }

        if (! in_array('avatar_urls', $this->appends)) {
            $this->appends[] = 'avatar_urls';
        }

        if (! in_array('avatar_html', $this->appends)) {
            $this->appends[] = 'avatar_html';
        }

        if (! in_array('media', $this->with)) {
            $this->with[] = 'media';
        }

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->performOnCollections('avatar');

        $this->addMediaConversion('small')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->performOnCollections('avatar');
    }

    /**
     * Handle avatar upload for entity.
     *
     * @param  string|\Illuminate\Http\UploadedFile|\Spatie\MediaLibrary\Support\RemoteFile  $avatar
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media
     */
    public function uploadAvatar($avatar)
    {
        return $this->addMedia($avatar)
            ->preservingOriginal()
            ->toMediaCollection('avatar');
    }

    /**
     * Get avatar fallback url.
     *
     * @param  string  $name
     * @return string
     */
    public function avatarFallbackUrl($name)
    {
        return config('saas.avatar_fallback_url').'?name='.urlencode($name);
    }

    /**
     * Check if an avatar exists.
     *
     * @return bool
     */
    public function getHasAvatarAttribute()
    {
        return $this->hasMedia('avatar');
    }

    /**
     * Get the avatar for the user model.
     *
     * @return string|null
     */
    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl('avatar');
    }

    /**
     * Get the avatar as html.
     *
     * @return string|null
     */
    public function getAvatarHtmlAttribute()
    {
        return $this->has_avatar ? $this->getFirstMedia('avatar')->toHtml() : null;
    }

    /**
     * Get the avatar responsive urls.
     *
     * @return array
     */
    public function getAvatarUrlsAttribute()
    {
        return [
            'thumbnail' => $this->getFirstMediaUrl('avatar', 'thumbnail'),
            'small' => $this->getFirstMediaUrl('avatar', 'small'),
        ];
    }
}
