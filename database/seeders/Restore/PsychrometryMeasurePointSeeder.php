<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;

class PsychrometryMeasurePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measurePoints = [
            ['name' => 'Outside'],
            ['name' => 'Unaffected'],
            ['name' => 'Affected'],
            ['name' => 'Dehumidifier'],
            ['name' => 'Hvac'],
        ];

        foreach ($measurePoints as $measurePoint) {
            PsychrometryMeasurePoint::firstOrCreate($measurePoint);
        }
    }
}
