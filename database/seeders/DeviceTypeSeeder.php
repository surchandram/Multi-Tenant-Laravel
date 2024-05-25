<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use SAAS\Domain\Devices\Models\DeviceType;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // device types
        foreach (\SAAS\Domain\Devices\Enums\DeviceType::cases() as $type) {
            DeviceType::firstOrCreate([
                'name' => $type->label(),
                'slug' => $type->value,
            ], [
                'usable' => true,
            ]);
        }
    }
}
