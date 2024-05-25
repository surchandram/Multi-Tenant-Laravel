<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use SAAS\Domain\Tenant\Models\OrganizationType;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizationTypes = [
            ['name' => 'Insurance'],
            ['name' => 'HOA'],
        ];

        foreach ($organizationTypes as $type) {
            OrganizationType::firstOrCreate($type);
        }
    }
}
