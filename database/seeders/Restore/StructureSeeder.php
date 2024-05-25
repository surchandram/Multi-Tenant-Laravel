<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\Structure;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // moisture map structures
        $moistureMapStructures = [
            ['name' => 'Ceiling'],
            ['name' => 'Flooring'],
            ['name' => 'Wall'],
        ];

        foreach ($moistureMapStructures as $structure) {
            Structure::firstOrCreate($structure);
        }
    }
}
