<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use SAAS\Domain\Pages\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Home',
                'uri' => '/',
                'name' => 'home',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'Packages',
                'uri' => '/packages',
                'name' => 'packages.index',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'About Us',
                'uri' => '/about',
                'name' => 'about.index',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'Contact Us',
                'uri' => '/contact-us',
                'name' => 'contact.index',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'Login',
                'uri' => '/login',
                'name' => 'login',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'Register',
                'uri' => '/register',
                'name' => 'register',
                'usable' => true,
                'hidden' => false,
            ],
            [
                'title' => 'Site',
                'uri' => '/site/management',
                'name' => 'site.management',
                'usable' => true,
                'hidden' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(Arr::only($page, 'uri'), $page);
        }
    }
}
