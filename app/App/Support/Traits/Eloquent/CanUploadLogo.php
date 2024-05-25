<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Spatie\Image\Manipulations;

trait CanUploadLogo
{
    /**
     * Boot `CanUploadLogo` trait.
     */
    public static function bootCanUploadLogo()
    {
        //
    }

    /**
     * Initialize the 'CanUploadLogo' trait for an instance.
     *
     * @return void
     */
    public function initializeCanUploadLogo()
    {
        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->performOnCollections('logo');

        $this->addMediaConversion('small')
            ->fit(Manipulations::FIT_CROP, 400, 400)
            ->performOnCollections('logo');
    }

    /**
     * Handle logo upload for entity.
     *
     * @param  string|\Illuminate\Http\UploadedFile|\Spatie\MediaLibrary\Support\RemoteFile  $logo
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media
     */
    public function uploadLogo($logo)
    {
        return $this->addMedia($logo)
            ->preservingOriginal()
            ->toMediaCollection('logo');
    }
}
