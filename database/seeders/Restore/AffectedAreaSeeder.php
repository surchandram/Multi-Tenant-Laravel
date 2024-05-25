<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\AffectedArea;

class AffectedAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // affected areas
        $affectedAreas = [
            ['name' => 'Attic'],
            ['name' => 'Basement'],
            ['name' => 'Bathroom'],
            ['name' => 'Bedroom'],
            ['name' => 'Closet'],
            ['name' => 'Den'],
            ['name' => 'Dining Room'],
            ['name' => 'Family Room'],
            ['name' => 'Foyer'],
            ['name' => 'Garage'],
            ['name' => 'Hallway'],
            ['name' => 'Kitchen'],
            ['name' => 'Laundry Room'],
            ['name' => 'Living Room'],
            ['name' => 'Utility Room'],
            ['name' => 'Nursery'],
            ['name' => 'Office'],
        ];

        foreach ($affectedAreas as $area) {
            AffectedArea::firstOrCreate($area);
        }
    }
}
