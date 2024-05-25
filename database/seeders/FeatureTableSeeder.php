<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            'users',
            'groups',
            'tasks',
            'milestones',
            'projects',
        ];

        foreach ($features as $feature) {
            \SAAS\Domain\Features\Models\Feature::firstOrCreate(['key' => Str::slug($feature)], [
                'name' => Str::title($feature),
                'usable' => true,
            ]);
        }
    }
}
