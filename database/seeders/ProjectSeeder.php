<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \SAAS\Domain\Tenant\Models\Project::factory()->count(3)->create();

        // company
        // email
        // phone
        // Address
        // measurement unit (feet, metres)
        // currency
        // default tax
        // license no
        // tax id
        // projects prefix
        // projects start no

        // teams
        // name
        // usable
        // Users (HasMany)

        // project steps structure
        // Work Authorization
        // Scopes
        // Moisture Map
        // Psychrometric Report
        // Certificate of Completion
        // Estimate
        // Estimate Summary
        // Daily Log
        // Customer Responsibility
        // Release from Liability
        // Work Stoppage
        // Anti-Microbial
        // Superiror Work Authorization

        // categories
        $categories = [
            ['name' => 'Air Movers'],
            ['name' => 'Dehumidifiers'],
            ['name' => 'Air Scrubbers'],
        ];

        // models
        $models = [
            ['name' => 'Layflats', 'category' => 'Air Movers'],
        ];

    }
}
