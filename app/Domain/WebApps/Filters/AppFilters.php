<?php

namespace SAAS\Domain\WebApps\Filters;

use Illuminate\Http\Request;
use Miracuthbert\Filters\FiltersAbstract;
use SAAS\App\Filters\Ordering\CreatedOrder;
use SAAS\Domain\Features\Filters\FeatureFilter;
use SAAS\Domain\Features\Models\Feature;

class AppFilters extends FiltersAbstract
{
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [
        'usable' => UsableFilter::class,
        'primary' => PrimaryFilter::class,
        'subscription' => AllowsSubscriptionFilter::class,
        'features' => FeatureFilter::class,
        'created' => CreatedOrder::class,
    ];

    /**
     * A list of default filters.
     *
     * @var array
     */
    protected $defaultFilters = [
        // 'created' => 'desc',
    ];

    /**
     * AppsFilter constructor
     * .
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        // use block below to change default filters
        // if ($request->hasAny('cancelled', 'completed')) {
        //    $this->defaultFilters = [
        //        'upcoming' => 'false'
        //    ];
        // }

        parent::__construct($request);
    }

    /**
     * A list of filters map.
     *
     * @return array
     */
    public static function mappings()
    {
        $map = [
            'features' => [
                'map' => Feature::get(['name', 'key'])
                            ->mapWithKeys(fn ($feature) => [$feature->key => $feature->name]),
                'type' => 'boolean',
                'heading' => __('Feature'),
            ],
            'usable' => [
                'map' => [
                    'true' => __('Active'),
                    'false' => __('Disabled'),
                ],
                'type' => 'boolean',
                'heading' => __('Status'),
            ],
            'primary' => [
                'map' => [
                    'true' => __('True'),
                    'false' => __('False'),
                ],
                'type' => 'boolean',
                'heading' => __('Primary app'),
            ],
            'subscription' => [
                'map' => [
                    'true' => __('Allowed'),
                    'false' => __('Disabled'),
                ],
                'type' => 'boolean',
                'heading' => __('Subscription'),
            ],
            'created' => [
                'map' => [
                    'desc' => __('Latest'),
                    'asc' => __('Older'),
                ],
                'heading' => __('Date Added'),
            ],
        ];

        // auth filters
        if (auth()->check()) {
            $authMap = [];

            $map = array_merge($map, $authMap);
        }

        return $map;
    }
}
