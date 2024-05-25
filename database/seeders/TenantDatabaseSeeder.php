<?php

namespace Database\Seeders;

use Database\Seeders\Restore\AffectedAreaSeeder;
use Database\Seeders\Restore\MaterialSeeder;
use Database\Seeders\Restore\ProjectCategorySeeder;
use Database\Seeders\Restore\ProjectClassSeeder;
use Database\Seeders\Restore\ProjectStatusSeeder;
use Database\Seeders\Restore\ProjectTypeSeeder;
use Database\Seeders\Restore\PsychrometryMeasurePointSeeder;
use Database\Seeders\Restore\StructureSeeder;
use Database\Seeders\Tenant\OrganizationTypeSeeder;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProjectStatusSeeder::class,
            ProjectTypeSeeder::class,
            ProjectClassSeeder::class,
            ProjectCategorySeeder::class,
            OrganizationTypeSeeder::class,
            AffectedAreaSeeder::class,
            StructureSeeder::class,
            MaterialSeeder::class,
            PsychrometryMeasurePointSeeder::class,
            DeviceTypeSeeder::class,
            DocumentTypeSeeder::class,
            DocumentSeeder::class,
            // ProjectSeeder::class,
        ]);
    }
}
