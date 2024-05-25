<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HomepageFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Do not use this in production
        // This seeder does not seed any table
        // These are just loose values stored in your local storage as a `JSON` file.
        // We used it in the homepage to list out features built within the saas boilerplate

        $features = [
            [
                "name" => "User Account Management",
                "overview" => "Built in user account area where they can update their profile, change password or deactivate their account.",
                "description" => null,
                "slug" => "user-account-management",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "Two Factor Authentication (2FA)",
                "overview" => "Two factor authentication with Authy",
                "description" => "Authy by Twilio",
                "slug" => "two-factor-authentication-2fa",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "User Subscriptions",
                "description" => "Custom blade templates and middleware included to enable you to prevent users without subscription from accessing subscription only features.",
                "overview" => "Built in user subscription powered by Stripe and Cashier",
                "slug" => "user-subscriptions",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "API Tokens",
                "overview" => "Users can view and manage their API tokens provided by your app.",
                "description" => "API tokens are based on the Laravel Passport package.",
                "slug" => "api-tokens",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "User Impersonation",
                "overview" => "Wanna debug a problem for your customers? You can impersonate them to view what problem they have.",
                "description" => null,
                "slug" => "user-impersonate",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "Teams",
                "overview" => "Users can create teams, manage team subscriptions, add, assign roles and remove team members. Plus create custom team roles on top of the default ones.",
                "description" => null,
                "slug" => "admin-panel",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
            [
                "name" => "Admin Panel",
                "overview" => "A bonus feature. You can manage your plans, roles, permissions, users and much more.",
                "description" => null,
                "slug" => "admin-panel",
                "usable" => true,
                "created_at" => now(),
                "edited_at" => null
            ],
        ];

        $features = collect($features)->keyBy('slug')->toArray();

        // $valuestore = \Spatie\Valuestore\Valuestore::make(storage_path('app/features.json'));

        // foreach ($features as $slug => $feature) {
        //     $valuestore->put($slug, $feature);
        // }
    }
}
