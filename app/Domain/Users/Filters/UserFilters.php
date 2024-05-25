<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/17/2018
 * Time: 12:02 PM
 */

namespace SAAS\Domain\Users\Filters;

use Miracuthbert\Filters\FiltersAbstract;
use SAAS\App\Filters\Dates\CreatedAtRangeFilter;
use SAAS\App\Filters\FiltersExtensionTrait;
use SAAS\App\Filters\Ordering\CreatedOrder;
use SAAS\App\Filters\Ordering\SortFilter;
use SAAS\Domain\Users\Models\Role;

class UserFilters extends FiltersAbstract
{
    use FiltersExtensionTrait;

    protected $filters = [
        'from' => CreatedAtRangeFilter::class,
        'to' => CreatedAtRangeFilter::class,
        'name' => NameFilter::class,
        'verified' => VerifiedFilter::class,
        'role' => RoleFilter::class,
        'created' => CreatedOrder::class,
        'sort_by' => SortFilter::class,
        'name_order' => SortFilter::class,
        'email_order' => SortFilter::class,
        'team_count_order' => SortFilter::class,
        'email_verified_at_order' => SortFilter::class,
    ];

    protected $defaultFilters = [
        'created' => 'desc',
    ];

    /**
     * Create project filters map.
     *
     * @return array
     */
    public static function mappings()
    {
        //use view composer to render categories

        $map = [
            'verified' => [
                'map' => [
                    'true' => 'True',
                    'false' => 'False',
                ],
                'heading' => 'Verified',
                'style' => 'list',
            ],
            'created' => [
                'map' => [
                    'desc' => 'Latest',
                    'asc' => 'Older',
                ],
                'heading' => 'Sort by Joined',
                'style' => 'list',
            ],
        ];

        //auth only filters
        if (auth()->check() && (auth()->user()->hasRole('admin-root') || auth()->user()->can('manage users'))) {
            $auth_map = [
                'role' => [
                    'map' => Role::whereType('admin')->get()->pluck('name', 'slug'),
                    'heading' => 'Roles',
                    'style' => 'list',
                ],
            ];

            $map = array_merge($map, $auth_map);
        }

        return $map;
    }
}
