<?php

namespace SAAS\Domain\WebApps\Enums\Apps;

use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Settings\DataTransferObjects\SettingData;
use SAAS\Domain\Settings\DataTransferObjects\SettingGroupData;

enum RestoreSettings: string
{
    case project = 'project';

    case notifications = 'notifications';

    case project_status = 'project_status';

    public static function settings()
    {
        return [

            /* projects */
            self::project->value => SettingGroupData::fromValues(
                'Projects',
                [
                    /* bool $allow_invoices */
                    'allow_invoices' => SettingData::from([
                        'label' => 'Allow invoices',
                        'value' => true,
                    ]),

                    /* int $completed_project_lockdown */
                    'completed_project_lockdown' => SettingData::from([
                        'label' => 'Completed project lockdown',
                        'value' => 60,
                    ]),
                ]
            ),

            /* notifications */
            self::notifications->value => SettingGroupData::fromValues(
                'Notifications',
                [

                    /* project */
                    self::project_status->value => SettingGroupData::fromValues(
                        'Project Status',
                        collect(ProjectStatuses::cases())
                            ->reject(
                                fn ($status) => in_array(
                                    $status->value,
                                    [
                                        ProjectStatuses::Draft->value,
                                        ProjectStatuses::Pending->value,
                                    ]
                                )
                            )
                            ->mapWithKeys(fn ($status) => [
                                $status->value => SettingGroupData::fromValues(
                                    $status->label(),
                                    [

                                        /* bool $active */
                                        'active' => SettingData::fromValues(
                                            'Active',
                                            true
                                        ),

                                        /* array $recipients */
                                        'recipients' => SettingData::fromValues(
                                            'Recipients',
                                            [

                                                /* bool $team */
                                                'team',

                                                /* bool $customer */
                                                'customer',
                                            ]
                                        )->additional(['choices' => ['team', 'customer', 'admin']]),

                                        /* array $notifications */
                                        'notifications' => SettingData::fromValues(
                                            'Notifications',
                                            ['email']
                                        )->additional(['choices' => ['email', 'push', 'sms']]),
                                    ],
                                )->additional([
                                    'priority' => $status->priorityLevel(),
                                ]),
                            ])
                            ->sortBy(function ($group) {
                                return $group->toArray()['priority'];
                            })
                            ->values()
                            ->toArray(),
                    ),
                ]
            ),
        ];
    }
}
