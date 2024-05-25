<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // project categories
        $projectCategories = [];

        for ($i = 1; $i <= 3; $i++) {
            $projectCategories[] = ['name' => $i];
        }

        foreach ($projectCategories as $category) {
            ProjectCategory::firstOrCreate($category);
        }
    }
}
