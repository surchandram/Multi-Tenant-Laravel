<?php

namespace SAAS\View\Composers;

use Illuminate\View\View;
use SAAS\Domain\Features\Models\Feature;
// use Spatie\Valuestore\Valuestore;

class FeaturesComposer
{
    /**
     * Features.
     *
     * @var $features
     */
    private $features;

    /**
     * FeaturesComposer constructor.
     */
    public function __construct()
    {
        // $this->features = Valuestore::make(storage_path('app/features.json'));
    }

    /**
     * Share features.
     *
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        $this->features = Feature::where('usable', true)->get();

        return $view->with('features', $this->features);
    }
}
