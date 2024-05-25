<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // moisture map materials
        $moistureMapMaterials = [
            ['name' => 'Bottom Plate', 'dry_goal' => 0],
            ['name' => 'Brick', 'dry_goal' => 0],
            ['name' => 'Carpet', 'dry_goal' => 0],
            ['name' => 'Concrete', 'dry_goal' => 0],
            ['name' => 'Drywall', 'dry_goal' => 13],
            ['name' => 'Hardwood', 'dry_goal' => 0],
            ['name' => 'Joist', 'dry_goal' => 0],
            ['name' => 'Laminate', 'dry_goal' => 0],
            ['name' => 'Linoleum', 'dry_goal' => 0],
            ['name' => 'Marble', 'dry_goal' => 0],
            ['name' => 'Paneling', 'dry_goal' => 0],
            ['name' => 'Sheathing', 'dry_goal' => 0],
            ['name' => 'Stud', 'dry_goal' => 16],
            ['name' => 'Subfloor', 'dry_goal' => 0],
            ['name' => 'Tile', 'dry_goal' => 0],
            ['name' => 'Wood', 'dry_goal' => 0],
        ];

        foreach ($moistureMapMaterials as $material) {
            Material::firstOrCreate($material);
        }
    }
}
