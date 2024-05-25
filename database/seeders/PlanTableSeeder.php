<?php

namespace Database\Seeders;

use SAAS\App\Support\Plans;
use Illuminate\Database\Seeder;
use SAAS\Domain\Plans\Models\Plan;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = Plans::$plans;

        Plan::createPlan($plans);
    }
}
