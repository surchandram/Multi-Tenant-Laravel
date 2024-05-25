<?php

namespace SAAS\Domain\Users\ValueObjects;

use Illuminate\Support\Arr;

class RoleType
{
    /**
     * RoleType constructor.
     *
     * @param  string  $type
     */
    public function __construct(
        public readonly ?string $type
    ) {
    }

    /**
     * Get new RoleType instance from given value.
     *
     * @param  string  $value
     * @return \SAAS\Domain\Users\ValueObjects\RoleType
     */
    public static function from(string $value): RoleType
    {
        return new self(
            type: Arr::get(array_flip(config('laravel-roles.models')), $value)
        );
    }
}
