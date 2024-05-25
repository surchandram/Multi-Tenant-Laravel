<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use SAAS\Domain\Tenant\Models\Person;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::factory()->count(5)->create();
    }
}
