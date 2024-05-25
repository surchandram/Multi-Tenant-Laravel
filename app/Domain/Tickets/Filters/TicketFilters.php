<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Http\Request;
use Miracuthbert\Filters\FiltersAbstract;
use Saasplayground\SupportTickets\SupportTickets;

class TicketFilters extends FiltersAbstract
{
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [
        'priority' => PriorityFilter::class,
        'status' => StatusFilter::class,
        'source' => SourceFilter::class,
        'categories' => CategoriesFilter::class,
        'labels' => LabelsFilter::class,
        'user' => UserFilter::class,
        'has_agent' => AssignedAgentFilter::class,
        'agent' => AgentFilter::class,
        'resolved' => ResolvedFilter::class,
        'locked' => LockedFilter::class,
        'archived' => ArchivedFilter::class,
        'resolved_order' => ResolvedOrder::class,
        'locked_order' => LockedOrder::class,
        'archived_order' => ArchivedOrder::class,
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
     * TicketFilters constructor
     * .
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        // use block below to change default filters
        if ($request->hasAny('archived', 'locked', 'resolved')) {
            $this->defaultFilters = [
                // 'upcoming' => 'false'
            ];
        }

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
            'priority' => [
                'map' => collect(SupportTickets::getPriorityMap())->mapWithKeys(fn ($value) => [$value => $value])->all(),
                'heading' => 'Priority',
                'type' => 'radio',
            ],
            'status' => [
                'map' => collect(SupportTickets::getStatusMap())->mapWithKeys(fn ($value) => [$value => $value])->all(),
                'heading' => 'Status',
                'type' => 'radio',
            ],
            'source' => [
                'map' => collect(SupportTickets::getSourcesMap())->mapWithKeys(fn ($value) => [$value => $value])->all(),
                'heading' => 'Source',
                'type' => 'radio',
            ],
            'has_agent' => [
                'map' => [
                    'true' => 'True',
                    'false' => 'False',
                ],
                'heading' => 'Has Agent',
                'type' => 'boolean',
            ],
            'resolved' => [
                'map' => [
                    'true' => 'True',
                    'false' => 'False',
                ],
                'heading' => 'Resolved',
                'type' => 'boolean',
            ],
            'locked' => [
                'map' => [
                    'true' => 'True',
                    'false' => 'False',
                ],
                'heading' => 'Locked',
                'type' => 'boolean',
            ],
            'archived' => [
                'map' => [
                    'true' => 'True',
                    'false' => 'False',
                ],
                'heading' => 'Archived',
                'type' => 'boolean',
            ],
            'resolved_order' => [
                'map' => [
                    'desc' => 'Recently',
                    'asc' => 'Older',
                ],
                'heading' => 'Order by Date Resolved',
                'type' => 'order',
            ],
            'locked_order' => [
                'map' => [
                    'desc' => 'Recently',
                    'asc' => 'Older',
                ],
                'heading' => 'Order by Date Locked',
                'type' => 'order',
            ],
            'archived_order' => [
                'map' => [
                    'desc' => 'Recently',
                    'asc' => 'Older',
                ],
                'heading' => 'Order by Date Archived',
                'type' => 'order',
            ],
            'created' => [
                'map' => [
                    'desc' => 'Latest',
                    'asc' => 'Older',
                ],
                'heading' => 'Date Created',
                'type' => 'order',
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
