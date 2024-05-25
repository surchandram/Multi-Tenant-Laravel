<?php

namespace SAAS\App\Pages\DataObjects;

use SAAS\Domain\Pages\Models\Page;

class PageData
{
    public function __construct(
        public readonly ?Page $pageData
    ) {
    }

    /**
     * Get the page's data.
     *
     * @return null|\SAAS\Domain\Pages\Models\Page
     */
    public function value()
    {
        return $this->pageData;
    }

    /**
     * Get a new instance of PageData object from route name.
     *
     * @param  string  $routeName
     * @return \SAAS\App\Pages\DataObjects\PageData
     */
    public static function make($routeName): PageData
    {
        $page = Page::with(['media'])
            ->where('name', $routeName)
            ->first()
            ?->withComponents();

        return new self(
            pageData: $page
        );
    }
}
