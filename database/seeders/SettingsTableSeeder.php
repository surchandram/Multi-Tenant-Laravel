<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'app.theme' => 'tailadmin',
            'title' => 'Cyberhawk',
            'tagline' => 'Your story starts with us.',
            'subtitle' => 'Sensors and Tracking for Teams.',
            'subscriptions.enabled' => 'true',
            'two_factor.enabled' => 'true',
            'account.deactivation' => 'true',
            'teams.allowed' => 'true',
            'teams.personal' => 'true',
            'teams.subdomains.allowed' => 'true',
            'footer.about' => 'The only Starter Kit you\'ll need to build a Team oriented SaaS.',
            'pages.home.seo_title' => 'SaaS Starter Kit',
            'pages.home.seo_description' => 'Powerful SaaS starter kit for building subscription based apps for teams',
            'pages.plans.title' => 'Personal Plans',
            'pages.plans.description' => 'Plans suitable for Personal use.',
            'pages.plans.teams.title' => 'Teams Plans',
            'pages.plans.teams.description' => 'Plans suitable for Teams.',
            'pages.support.tickets.title' => 'My Support Tickets',
            'pages.support.tickets.create.title' => 'Open a Ticket',
            'pages.dashboard.user_summary_card' => 'Here, you\'ll see an overview of your account\'s activity.',
            'pages.dashboard.personal_team_create_label' => 'To start using apps,',
            'pages.dashboard.create_team_label' => 'To add a new team,',
        ];

        setting($settings);
        setting()->save();
    }
}
