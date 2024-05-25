<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Enums\ProjectStatuses as ProjectStatuses;
use SAAS\Domain\Restore\Models\ProjectStatus;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ['name' => 'Draft'],
        // ['name' => 'Pending'],
        // ['name' => 'Ongoing'],
        // ['name' => 'Invoiced'],
        // ['name' => 'Paid'],
        // ['name' => 'Payment Failed'],
        // ['name' => 'Completed'],
        // ['name' => 'Cancelled'],

        foreach (ProjectStatuses::cases() as $status) {
            ProjectStatus::firstOrCreate([
                'name' => $status->label(),
                'slug' => $status->value,
            ]);
        }
    }
}
