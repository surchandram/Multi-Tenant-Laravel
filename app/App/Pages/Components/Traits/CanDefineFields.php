<?php

namespace SAAS\App\Pages\Components\Traits;

use SAAS\Domain\Pages\Models\PageComponent;

trait CanDefineFields
{
    /**
     * Handles page component type definition.
     *
     * @param  array  $data
     * @return \SAAS\App\Pages\Components\AbstractPageComponent
     */
    public static function define(array $data)
    {
        return new self(
            key: $data['key'],
            value: $data['value']
        );
    }

    /**
     * Create a page component type instance from array.
     *
     * @param  array  $data
     * @return \SAAS\App\Pages\Components\AbstractPageComponent
     */
    public static function fromArray(array $data)
    {
        return new self(
            key: $data['key'],
            value: $data['value'],
        );
    }

    /**
     * Create a page component type instance from model.
     *
     * @param  PageComponent  $pageComponent
     * @return \SAAS\App\Pages\Components\AbstractPageComponent
     */
    public static function fromModel(PageComponent $pageComponent)
    {
        return new self(
            key: $pageComponent->name,
            value: self::fromArray($pageComponent->data),
        );
    }
}
