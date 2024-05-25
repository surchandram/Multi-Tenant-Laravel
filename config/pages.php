<?php

return [

    /**
     * Page Components Settings.
     */
    'components' => [

        /**
         * Page Component Types.
         *
         * Register page components types here to enable their use.
         */
        'types' => [
            'TextComponent' => \SAAS\App\Pages\Components\Types\TextComponent::class,
            'NumberComponent' => \SAAS\App\Pages\Components\Types\NumberComponent::class,
            'HtmlComponent' => \SAAS\App\Pages\Components\Types\HtmlComponent::class,
            'ImageComponent' => \SAAS\App\Pages\Components\Types\ImageComponent::class,
            'AppComponent' => \SAAS\App\Pages\Components\Types\AppComponent::class,
            'HeroTitleComponent' => \SAAS\App\Pages\Components\Types\HeroTitleComponent::class,
            'HeroServicesComponent' => \SAAS\App\Pages\Components\Types\HeroServicesComponent::class,
            'HeroServiceComponent' => \SAAS\App\Pages\Components\Types\HeroServiceComponent::class,
            'TeamSectionComponent' => \SAAS\App\Pages\Components\Types\TeamSectionComponent::class,
            'TeamMemberComponent' => \SAAS\App\Pages\Components\Types\TeamMemberComponent::class,
            'TeamUserComponent' => \SAAS\App\Pages\Components\Types\TeamUserComponent::class,
            'SocialLinkComponent' => \SAAS\App\Pages\Components\Types\SocialLinkComponent::class,
        ],
    ],
];
