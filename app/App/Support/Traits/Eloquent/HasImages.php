<?php

namespace SAAS\App\Support\Traits\Eloquent;

trait HasImages
{
    /**
     * Boot 'HasImages' trait for a model.
     *
     * @return void
     */
    public static function bootHasImages()
    {
        //
    }

    /**
     * Initialize the 'HasImages' trait for an instance.
     *
     * @return void
     */
    public function initializeHasImages()
    {
        if (! in_array('has_images', $this->appends)) {
            $this->appends[] = 'has_images';
        }

        if (! in_array('images', $this->appends)) {
            $this->appends[] = 'images';
        }

        if (! in_array('images_urls', $this->appends)) {
            $this->appends[] = 'images_urls';
        }

        if (! in_array('images_html', $this->appends)) {
            $this->appends[] = 'images_html';
        }

        if (! in_array('has_main_image', $this->appends)) {
            $this->appends[] = 'has_main_image';
        }

        if (! in_array('main_image', $this->appends)) {
            $this->appends[] = 'main_image';
        }

        if (! in_array('main_image_urls', $this->appends)) {
            $this->appends[] = 'main_image_urls';
        }

        if (! in_array('main_image_html', $this->appends)) {
            $this->appends[] = 'main_image_html';
        }
    }

    /**
     * Check if a images exists.
     *
     * @return bool
     */
    public function getHasImagesAttribute()
    {
        return $this->hasMedia('images');
    }

    /**
     * Check if a main_image exists.
     *
     * @return bool
     */
    public function getHasMainImageAttribute()
    {
        return $this->hasMedia('main_image');
    }

    /**
     * Get the main_image for the app.
     *
     * @return string|null
     */
    public function getMainImageAttribute()
    {
        return $this->has_main_image ? $this->getFirstMediaUrl('main_image') : null;
    }

    /**
     * Get the main_image as html.
     *
     * @return string|null
     */
    public function getMainImageHtmlAttribute()
    {
        return $this->has_main_image ? $this->getFirstMedia('main_image')->toHtml() : null;
    }

    /**
     * Get the main_image responsive urls.
     *
     * @return array
     */
    public function getMainImageUrlsAttribute()
    {
        return $this->has_main_image ? $this->getFirstMedia('main_image')->getResponsiveImageUrls() : [];
    }

    /**
     * Get the images for the app.
     *
     * @return string[]|null
     */
    public function getImagesAttribute()
    {
        return $this->has_images ? $this->getMedia('images') : null;
    }

    /**
     * Get the images as html.
     *
     * @return string|null
     */
    public function getImagesHtmlAttribute()
    {
        return $this->has_images ? $this->getMedia('images')->map(fn ($media) => $media->toHtml()) : null;
    }

    /**
     * Get the images responsive urls.
     *
     * @return array
     */
    public function getImagesUrlsAttribute()
    {
        return $this->has_images ? $this->getMedia('images')->map(fn ($media) => $media->getResponsiveImageUrls()) : [];
    }
}
