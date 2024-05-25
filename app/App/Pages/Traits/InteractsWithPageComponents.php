<?php

namespace SAAS\App\Pages\Traits;

use SAAS\App\Pages\Components\PageComponents;
use SAAS\Domain\Pages\Models\PageComponent;

trait InteractsWithPageComponents
{
    /**
     * Boots 'InteractsWithPageComponents' trait.
     */
    public static function bootInteractsWithPageComponents()
    {
    }

    /**
     * Initialize the 'InteractsWithPageComponents' trait for an instance.
     *
     * @return void
     */
    public function initializeInteractsWithPageComponents()
    {
        if (! in_array('page_components', $this->appends)) {
            $this->appends[] = 'page_components';
        }
    }

    public function scopeWithComponents()
    {
        return $this->loadMissing(['components']);
    }

    public function getPageComponentsAttribute()
    {
        return PageComponents::collect($this->components)->keyBy('key')->all();
    }

    public function components()
    {
        return $this->hasMany(PageComponent::class);
    }
}
