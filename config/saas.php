<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | This value is the default currency used within the app.
    | eg. billing
    | Make sure you change corresponding values in '.env' file.
    |
    */
    'currency' => 'USD',

    /**
     * Logo Settings.
     */
    'logo_fallback_url' => env('LOGO_URL', 'https://placehold.co/800x800?text='),

    /**
     * Avatar Settings.
     */
    'avatar_fallback_url' => env('AVATAR_URL', 'https://ui-avatars.com/api/'),

    /**
     * Company Domain Change Lock in days
     */
    'company_domain_change_lock' => 60,

    /*
    |--------------------------------------------------------------------------
    | Features Settings
    |--------------------------------------------------------------------------
    |
    | The values to be used to control features within the app.
    |
    */
    'features' => [

        /*
        |--------------------------------------------------------------------------
        | Allowed Features
        |--------------------------------------------------------------------------
        |
        | Set the features that can be accessed by the app user's.
        |
        | To use this option to control accessibility, call the global
        | 'feature' method passing in a key and default (false) value.
        |
        | Note: You can also use it to control, login, registration, etc.
        |
        */
        'allowed' => [
            'projects',
            'projects.files',
        ],

        /*
        |--------------------------------------------------------------------------
        | Models Settings
        |--------------------------------------------------------------------------
        |
        | Set the corresponding models based on a feature's 'key'
        | within the app.
        |
        */
        'models' => [
            // 'groups' => \SAAS\Domain\Tenant\Models\Groups::class,
            'projects' => \SAAS\Domain\Restore\Models\Project::class,
        ],

        /*
        |--------------------------------------------------------------------------
        | Tenant Migration Settings
        |--------------------------------------------------------------------------
        |
        | Set the corresponding migration path based on a feature's 'key'
        | within the app.
        |
        */
        'migrations' => [
            // 'cms' => database_path('migrations/tenant/cms'),
            // 'chat' => database_path('migrations/tenant/chat'),
            // 'crm' => database_path('migrations/tenant/crm'),
        ],
    ],

    /**
     * User Invitations
     *
     * Used to create
     */
    'invitations' => [

        /**
         * Default Invitation Type.
         */
        'default' => 'referral',

        /**
         * Invitation Types.
         */
        'types' => [
            'admin' => 'Admin',
            'team' => 'Team',
            'company' => 'Company',
        ],

        /**
         * Invitation Handlers.
         */
        'handlers' => [
            'admin' => \SAAS\App\UserInvitations\Handlers\AdminInvitationHandler::class,
            'company' => \SAAS\App\UserInvitations\Handlers\CompanyUserInvitationHandler::class,
        ],

        /**
         * Roleable Models.
         */
        'models' => [
            'company' => \SAAS\Domain\Companies\Models\Company::class,
            'team' => \SAAS\Domain\Companies\Models\Company::class,
        ],

        /**
         * Invitation Mails.
         */
        'mails' => [
            \SAAS\Domain\Restore\Invitations\CustomerInvitation::class => \SAAS\Domain\Restore\Mails\CustomerInvitationMail::class,
        ],

        /**
         * Invitation Expiry Date.
         */
        'expiry' => [
            \SAAS\Domain\Restore\Invitations\CustomerInvitation::class => 15,
        ],

        /**
         * Invitation Mails Templates.
         */
        'mail_templates' => [
            'team' => 'emails.teams.invitations.created',
        ],
    ],
];
