<?php

namespace SAAS\App\Pages\Components\Types;

use SAAS\App\Pages\Components\AbstractPageComponent;
use SAAS\App\Pages\Components\Traits\CanDefineFields;

class NumberComponent extends AbstractPageComponent
{
    use CanDefineFields;

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
            value: (int) $data['value'],
        );
    }
}
