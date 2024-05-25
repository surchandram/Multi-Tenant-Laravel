<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Tenant\Models\Team;
use SAAS\Domain\Users\Models\User;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::transaction(function () {
                Team::factory()->count(3)
                    ->hasAttached(
                        User::factory()->count(2),
                        [],
                        'users'
                    )
                    ->create();
            });
        } catch (\Exception $e) {
            //
        }
    }
}
