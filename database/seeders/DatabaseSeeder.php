<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \SAAS\Domain\Users\Models\User::factory(10)->create();

        $this->call(SettingsTableSeeder::class);
        $this->call(FeatureTableSeeder::class);
        $this->call(RolesAndPermissionsTablesSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(PageComponentSeeder::class);
        $this->call(AppSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(DocumentSeeder::class);

        $user = \SAAS\Domain\Users\Models\User::updateOrCreate([
            'username' => 'rootadmin',
            'email' => 'root@admin.com',
        ], [
            'first_name' => 'Root',
            'last_name' => 'Admin',
            'phone' => null,
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
        $user->assignRole(\SAAS\Domain\Users\Models\Role::whereSlug('admin-root')->first());
    }
}
