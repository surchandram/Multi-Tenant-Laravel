<?php

namespace SAAS\App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laraeast\LaravelSettings\Facades\Settings;
use SAAS\App\Exceptions\Site\CannotUploadSiteLogo;
use SAAS\Domain\Pages\Models\Page;

class SiteManager
{
    const PAGE_NAME = 'site.management';

    /**
     * Instance of Page model.
     *
     * @var \SAAS\Domain\Pages\Models\Page
     */
    protected Page $page;

    /**
     * SiteManager Constructor.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get SiteManager instance from container.
     *
     * @return \SAAS\App\Support\SiteManager
     */
    public static function make(): SiteManager
    {
        return app(SiteManager::class);
    }

    /**
     * Get page data.
     *
     * @return \SAAS\Domain\Pages\Models\Page
     */
    public function getPageData(): Page
    {
        return $this->page;
    }

    /**
     * Get page that holds logo data.
     *
     * @return \SAAS\Domain\Pages\Models\Page
     */
    public function getLogoData()
    {
        $page = $this->getPageData();

        $page->loadMedia('logo');

        return $page;
    }

    /**
     * Handle site logo upload from an uploaded file.
     *
     * @param  UploadedFile  $logo [description]
     * @return void
     *
     * @throws \SAAS\App\Exceptions\Site\CannotUploadSiteLogo
     */
    public function uploadSiteLogo(UploadedFile $logo)
    {
        try {
            $page = $this->getPageData();

            DB::transaction(function () use (&$page, $logo) {
                $media = $page->addMedia($logo)
                    ->withResponsiveImages()
                    ->toMediaCollection('logo');

                Settings::set('site_logo', $media->uuid);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw CannotUploadSiteLogo::because($e->getMessage(), $e->getTrace());
        }
    }
}
