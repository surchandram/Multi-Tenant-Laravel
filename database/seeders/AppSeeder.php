<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SAAS\Domain\WebApps\Actions\UpsertAppAction;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apps = [
            [
                'name' => 'Restore',
                'key' => 'restore',
                'url' => 'restore',
                'description' => 'Project management with Moisture Journal and Psychrometric Report',
                'usable' => 1,
                'teams_only' => 1,
                'primary' => 1,
                'subscription' => 1,
                'features' => [
                    [
                        'name' => 'Project Management',
                        'key' => 'project_management',
                        'usable' => true,
                    ],
                    [
                        'name' => 'Moisture Map',
                        'key' => 'moisture_map',
                        'usable' => true,
                    ],
                    [
                        'name' => 'Psychrometric Report',
                        'key' => 'psychrometric_report',
                        'usable' => true,
                    ],
                    [
                        'name' => 'Work Authorization',
                        'key' => 'work_authorization',
                        'usable' => true,
                    ],
                    [
                        'name' => 'Report Export',
                        'key' => 'report_export',
                        'usable' => true,
                    ],
                ],
            ],
            [
                'name' => 'Shipkit',
                'key' => 'shipkit',
                'url' => 'shipkit',
                'description' => 'GPS tracking for vehicles',
                'usable' => 1,
                'teams_only' => 1,
                'primary' => 1,
                'subscription' => 1,
                'features' => [],
            ],
        ];

        foreach ($apps as $app) {
            UpsertAppAction::execute(
                AppData::from($app)
            );
        }
    }
}
