<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings Keys Casting
    |--------------------------------------------------------------------------
    |
    | Set the cast type for different setting keys
    |
    */
    'default_cast' => 'string',

    'casts' => [
        'title' => 'string',
        'subtitle' => 'string',
        'subscriptions.enabled' => 'boolean',
        'two_factor.enabled' => 'boolean',
        'account.deactivation' => 'boolean',
        'teams.allowed' => 'boolean',
        'teams.subdomains.allowed' => 'boolean',
        'footer.about' => 'text',
        'pages.home.seo_title' => 'string',
        'pages.home.seo_description' => 'string',
        'pages.plans.title' => 'string',
        'pages.plans.description' => 'string',
        'pages.plans.teams.title' => 'string',
        'pages.plans.teams.description' => 'string',
        'pages.support.tickets.title' => 'string',
        'pages.support.tickets.create.title' => 'string',
    ],
];
