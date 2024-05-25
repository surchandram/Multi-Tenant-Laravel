<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SAAS\App\Pages\Components\Types\ArrayComponent;
use SAAS\App\Pages\Components\Types\HeroServiceComponent;
use SAAS\App\Pages\Components\Types\HtmlComponent;
use SAAS\App\Pages\Components\Types\IconComponent;
use SAAS\App\Pages\Components\Types\ImageComponent;
use SAAS\App\Pages\Components\Types\TeamMemberComponent;
use SAAS\App\Pages\Components\Types\TextComponent;
use SAAS\Domain\Pages\Models\Page;
use SAAS\Domain\Pages\Models\PageComponent;

class PageComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            [
                'page' => 'home',
                'name' => 'home_hero.call_to_action',
                'type' => 'TextComponent',
                'data' => 'Get Started',
            ],

            [
                'page' => 'home',
                'name' => 'home_hero.title_section',
                'type' => 'HeroTitleComponent',
                'data' => [
                    TextComponent::define([
                        'key' => 'title',
                        'value' => 'Your story starts with us.',
                    ]),
                    TextComponent::define([
                        'key' => 'subtitle',
                        'value' => 'Simplified sensing and tracking for Teams.',
                    ]),
                ],
            ],

            [
                'page' => 'home',
                'name' => 'home_hero.services',
                'type' => 'HeroServicesComponent',
                'data' => [
                    HeroServiceComponent::define([
                        'key' => 'service_1',
                        'value' => [
                            IconComponent::define([
                                'key' => 'icon',
                                'value' => 'mortarboard',
                            ]),
                            TextComponent::define([
                                'key' => 'heading',
                                'value' => 'Devices and Log Access',
                            ]),
                            TextComponent::define([
                                'key' => 'overview',
                                'value' => 'Synchronized devices management and log access.',
                            ]),
                        ],
                    ]),
                    HeroServiceComponent::define([
                        'key' => 'service_2',
                        'value' => [
                            IconComponent::define([
                                'key' => 'icon',
                                'value' => 'person-gear',
                            ]),
                            TextComponent::define([
                                'key' => 'heading',
                                'value' => 'Teams',
                            ]),
                            TextComponent::define([
                                'key' => 'overview',
                                'value' => 'Intergrated team management tool.',
                            ]),
                        ],
                    ]),
                    HeroServiceComponent::define([
                        'key' => 'service_3',
                        'value' => [
                            IconComponent::define([
                                'key' => 'icon',
                                'value' => 'credit-card',
                            ]),
                            TextComponent::define([
                                'key' => 'heading',
                                'value' => 'Simplified Billing',
                            ]),
                            TextComponent::define([
                                'key' => 'overview',
                                'value' => 'Transparent and flexible billing that grows with you.',
                            ]),
                        ],
                    ]),
                ],
            ],

            [
                'page' => 'home',
                'name' => 'home_apps_promo',
                'type' => 'AppComponent',
                'data' => [
                    TextComponent::define([
                        'key' => 'heading',
                        'value' => 'Why use our apps?',
                    ]),
                    HtmlComponent::define([
                        'key' => 'overview',
                        'value' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Amet quis commodi maxime exercitationem. Nostrum, numquam! Lorem ipsum dolor sit, amet consectetur, adipisicing elit. Sapiente, nihil, ipsa? Excepturi commodi, veritatis sequi quia similique! Quia nemo quas, excepturi placeat nisi et vero facilis quos ducimus, ipsa, aspernatur.',

                    ]),
                ],
            ],

            [
                'page' => 'home',
                'name' => 'home_team_section',
                'type' => 'TeamSectionComponent',
                'data' => [
                    TextComponent::define([
                        'key' => 'heading',
                        'value' => 'Here are our Heroes',
                    ]),
                    TextComponent::define([
                        'key' => 'subtitle',
                        'value' => 'A paragraph is enough but it goes far to show the value of your team.',

                    ]),
                    TeamMemberComponent::define([
                        'key' => 'members',
                        'value' => [
                            [
                                ArrayComponent::define([
                                    'key' => 'bio',
                                    'value' => [
                                        TextComponent::define([
                                            'key' => 'name',
                                            'value' => 'John Doe',
                                        ]),
                                        TextComponent::define([
                                            'key' => 'position',
                                            'value' => 'Web Designer',
                                        ]),
                                        ImageComponent::define([
                                            'key' => 'avatar',
                                            'value' => Str::uuid(),
                                        ]),
                                    ],
                                ]),
                                ArrayComponent::define([
                                    'key' => 'social',
                                    'value' => [
                                        [
                                            TextComponent::define([
                                                'key' => 'platform',
                                                'value' => 'fb',
                                            ]),
                                            TextComponent::define([
                                                'key' => 'username',
                                                'value' => uniqid(),
                                            ]),
                                        ],
                                    ],
                                ]),
                            ],
                        ],
                    ]),
                ],
            ],
        ];

        $pages = Page::whereIn('name', collect($components)->pluck('page')->unique())->get();

        $pages->each(function ($page) use ($components) {
            collect($components)->where('page', $page->name)->each(function ($pageComponent) use ($page) {
                PageComponent::updateOrCreate(
                    array_merge(
                        Arr::only($pageComponent, ['name']),
                        $pageId = ['page_id' => $page->id]
                    ),
                    array_merge(
                        Arr::except($pageComponent, ['page']),
                        $pageId
                    )
                );
            });
        });
    }
}
