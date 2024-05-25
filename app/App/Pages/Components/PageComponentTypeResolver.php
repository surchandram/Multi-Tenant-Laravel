<?php

namespace SAAS\App\Pages\Components;

use Illuminate\Support\Arr;
use SAAS\App\Pages\Exceptions\CannotResolvePageComponentType;

class PageComponentTypeResolver
{
    public static function resolve($type)
    {
        $class = Arr::get(config('pages.components.types'), $type);

        if (! $class) {
            throw CannotResolvePageComponentType::because(
                "The page component type resolver for [$type] is not registered or does not exist."
            );
        }

        if (! class_exists($class)) {
            throw CannotResolvePageComponentType::because(
                "The page component type resolver for [$type] does not exist."
            );
        }

        if (! is_a($class, AbstractPageComponent::class, true)) {
            throw CannotResolvePageComponentType::because(
                sprintf(
                    'The page component type resolver for [%s] must be an instance of [%s].',
                    $class,
                    AbstractPageComponent::class
                )
            );
        }

        return $class;
    }
}
