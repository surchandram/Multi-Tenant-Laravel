<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\ProjectType;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // project types
        $projectTypes = [
            ['name' => 'Cleaning'],
            ['name' => 'Fire'],
            ['name' => 'Mitigation'],
            ['name' => 'Mold'],
            ['name' => 'Sewage'],
            ['name' => 'Water'],
        ];

        foreach ($projectTypes as $type) {
            ProjectType::firstOrCreate($type);
        }
    }
}
