<?php

namespace SAAS\App\Support\Traits\Eloquent;

trait HasLogo
{
    use CanUploadLogo;

    /**
     * Boot 'HasLogo' trait for a model.
     *
     * @return void
     */
    public static function bootHasLogo()
    {
        //
    }

    /**
     * Initialize the 'HasLogo' trait for an instance.
     *
     * @return void
     */
    public function initializeHasLogo()
    {
        $this->addMediaCollection('logo')
            ->useFallbackUrl($this->logoFallbackUrl())
            ->singleFile();

        if (! in_array('has_logo', $this->appends)) {
            $this->appends[] = 'has_logo';
        }

        if (! in_array('logo', $this->appends)) {
            $this->appends[] = 'logo';
        }

        if (! in_array('logo_urls', $this->appends)) {
            $this->appends[] = 'logo_urls';
        }

        if (! in_array('logo_html', $this->appends)) {
            $this->appends[] = 'logo_html';
        }

        if (! in_array('media', $this->with)) {
            $this->with[] = 'media';
        }
    }

    /**
     * Get logo fallback url.
     *
     * @param  string  $name
     * @return string
     */
    public function logoFallbackUrl($name = 'logo')
    {
        return config('saas.logo_fallback_url').urlencode($name);
    }

    /**
     * Check if a logo exists.
     *
     * @return bool
     */
    public function getHasLogoAttribute()
    {
        return $this->hasMedia('logo');
    }

    /**
     * Get the logo for the app.
     *
     * @return string|null
     */
    public function getLogoAttribute()
    {
        return $this->getFirstMediaUrl('logo');
    }

    /**
     * Get the logo as html.
     *
     * @return string|null
     */
    public function getLogoHtmlAttribute()
    {
        return $this->has_logo ? $this->getFirstMedia('logo')->toHtml() : null;
    }

    /**
     * Get the logo responsive urls.
     *
     * @return array
     */
    public function getLogoUrlsAttribute()
    {
        return $this->has_logo ? $this->getFirstMedia('logo')->getResponsiveImageUrls() : [];
    }
}
