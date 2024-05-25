<?php

namespace SAAS\Domain\Restore\Filters;

use Illuminate\Http\Request;
use Miracuthbert\Filters\FiltersAbstract;
use SAAS\App\Filters\Ordering\CreatedOrder;

class ProjectFilters extends FiltersAbstract
{
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [
        'created' => CreatedOrder::class,
    ];

    /**
     * A list of default filters.
     *
     * @var array
     */
    protected $defaultFilters = [
        'created' => 'desc',
    ];

    /**
     * ProjectFilters constructor
     * .
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
            'created' => [
                'map' => [
                    'desc' => 'Latest',
                    'asc' => 'Older',
                ],
                'heading' => 'Date Created',
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
