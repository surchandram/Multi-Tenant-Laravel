<?php

namespace SAAS\App\Pages\Components;

use Illuminate\Support\Collection;

class PageComponentsMapper
{
    public static function mapped($data)
    {
        return Collection::make($data)->mapWithKeys(function ($component, $key) {
            $value = static::mappedValue($component['value']);

            return [$key => $value];
        });
    }

    public static function mappedValue($data)
    {
        return is_array($data) ? Collection::make($data)->keyBy('key') : $data;
    }
}
