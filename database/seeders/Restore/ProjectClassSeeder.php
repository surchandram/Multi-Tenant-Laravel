<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\ProjectClass;

class ProjectClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // project classes
        $projectClasses = [];

        for ($i = 1; $i <= 4; $i++) {
            $projectClasses[] = ['name' => $i];
        }

        foreach ($projectClasses as $class) {
            ProjectClass::firstOrCreate($class);
        }
    }
}
