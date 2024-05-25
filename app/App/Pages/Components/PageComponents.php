<?php

namespace SAAS\App\Pages\Components;

use Illuminate\Support\Collection;

class PageComponents
{
    public function __construct(
        public readonly string $key,
        public readonly string $type,
        public readonly mixed $value,
    ) {
    }

    public static function collect($components)
    {
        $collection = [];

        foreach ($components as $pageComponent) {
            $component = new self(
                key: $pageComponent->name,
                type: $pageComponent->type,
                value: PageComponentValue::make($pageComponent)->value(),
            );

            $collection[] = $component->toArray();
        }

        return Collection::make($collection);
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
