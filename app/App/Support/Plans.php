<?php

namespace SAAS\App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\Models\Plan;

class Plans
{

    /**
     * List of plans to be seeded and synced.
     *
     * @var array $plans
     **/
    public static $plans = [
        [
            'name' => 'Dev',
            'provider_id' => 'monthly_3',
            'price' => '399',
            'usable' => true,
            'features' => [
                [
                    'name' => 'Groups',
                    'key' => 'groups',
                    'limit' => '3',
                    'usable' => true
                ],
                [
                    'name' => 'Tasks',
                    'key' => 'tasks',
                    'limit' => '50',
                    'usable' => true
                ],
                [
                    'name' => 'Milestones',
                    'key' => 'milestones',
                    'limit' => '4',
                    'usable' => true
                ],
                [
                    'name' => 'Projects',
                    'key' => 'projects',
                    'limit' => '2',
                    'usable' => true
                ],
            ],
        ],
        [
            'name' => 'Monthly',
            'provider_id' => 'monthly_10',
            'price' => '1000',
            'usable' => true,
            'features' => [
                [
                    'name' => 'Groups',
                    'key' => 'groups',
                    'limit' => '5',
                    'usable' => true
                ],
                [
                    'name' => 'Tasks',
                    'key' => 'tasks',
                    'limit' => '50',
                    'usable' => true
                ],
                [
                    'name' => 'Milestones',
                    'key' => 'milestones',
                    'limit' => '10',
                    'usable' => true
                ],
                [
                    'name' => 'Projects',
                    'key' => 'projects',
                    'limit' => '5',
                    'usable' => true
                ],
            ],
        ],
        [
            'name' => 'Yearly',
            'interval' => 'year',
            'provider_id' => 'yearly_100',
            'price' => '10000',
            'usable' => true,
            'features' => [
                [
                    'name' => 'Groups',
                    'key' => 'groups',
                    'limit' => '10',
                    'usable' => true
                ],
                [
                    'name' => 'Tasks',
                    'key' => 'tasks',
                    'limit' => '200',
                    'usable' => true
                ],
                [
                    'name' => 'Milestones',
                    'key' => 'milestones',
                    'limit' => '20',
                    'usable' => true
                ],
                [
                    'name' => 'Projects',
                    'key' => 'projects',
                    'limit' => '8',
                    'usable' => true
                ],
            ],
        ],
        [
            'name' => 'Monthly for 5 users',
            'provider_id' => 'monthly_users_5',
            'price' => '6000',
            'teams' => true,
            'usable' => true,
            'features' => [
                [
                    'name' => 'Users',
                    'key' => 'users',
                    'limit' => '5',
                    'usable' => true,
                    'default' => true
                ],
                [
                    'name' => 'Groups',
                    'key' => 'groups',
                    'limit' => '15',
                    'usable' => true
                ],
                [
                    'name' => 'Tasks',
                    'key' => 'tasks',
                    'limit' => '500',
                    'usable' => true
                ],
                [
                    'name' => 'Milestones',
                    'key' => 'milestones',
                    'limit' => '30',
                    'usable' => true
                ],
                [
                    'name' => 'Projects',
                    'key' => 'projects',
                    'limit' => '10',
                    'usable' => true
                ],
            ],
        ],
        [
            'name' => 'Monthly for 10 users',
            'provider_id' => 'monthly_users_10',
            'price' => '10000',
            'teams' => true,
            'usable' => true,
            'features' => [
                [
                    'name' => 'Users',
                    'key' => 'users',
                    'limit' => '10',
                    'usable' => true,
                    'default' => true,
                ],
                [
                    'name' => 'Groups',
                    'key' => 'groups',
                    'limit' => '25',
                    'usable' => true,
                ],
                [
                    'name' => 'Tasks',
                    'key' => 'tasks',
                    'limit' => '1000',
                    'usable' => true,
                ],
                [
                    'name' => 'Milestones',
                    'key' => 'milestones',
                    'limit' => '50',
                    'usable' => true,
                ],
                [
                    'name' => 'Projects',
                    'key' => 'projects',
                    'limit' => '15',
                    'usable' => true,
                ],
            ],
        ],
    ];

    /**
     * Sync plan features to plans in database
     *
     * Undocumented function long description
     *
     * @return void
     **/
    public static function sync($createMissing = true)
    {
        foreach (static::$plans as $key => $data) {
            $providerId = $data['provider_id'];

            $plan = $createMissing ? Plan::firstOrCreate(
                [
                    'provider_id' => $providerId
                ],
                Arr::except($data, ['provider_id', 'features'])

            ) : Plan::where('provider_id', $providerId)->first();

            if (!$plan) {
                return;
            }

            foreach ($data['features'] as $key => $feature) {
                $featured = Feature::firstOrCreate(['key' => Str::slug($feature['key'])], [
                    'name' => Str::title($feature['name']),
                    'usable' => true,
                ]);

                $default = $feature['default'] ?? false;

                if (!$plan->hasFeature($featured)) {
                    $plan->features()->create([
                        'feature_id' => ($featured->id),
                        'limit' => ($feature['limit']),
                        'default' => $default,
                    ]);
                }
            }
        }
    }
}
