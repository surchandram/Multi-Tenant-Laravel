<?php

namespace SAAS\App\Pages\Components;

use SAAS\Domain\Pages\Models\PageComponent;

class PageComponentValue
{
    public function __construct(
        public readonly string $key,
        public readonly string $type,
        public readonly mixed $value,
    ) {
    }

    public static function make(PageComponent $pageComponent)
    {
        $class = PageComponentTypeResolver::resolve($pageComponent->type);
        $pageComponent->typeClass = $class;

        return $class::define([
            'key' => $pageComponent->name,
            'typeClass' => $pageComponent->typeClass,
            'value' => $pageComponent->data,
        ]);
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
