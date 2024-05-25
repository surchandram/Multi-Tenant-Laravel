<?php

namespace SAAS\Lang\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GetLocaleTranslationsAction
{
    public static function execute(string $locale): array|Collection
    {
        $exists = File::exists($path = base_path('lang/'.$locale));

        if (! $exists) {
            $path = base_path('lang/'.($locale = config('app.fallback_locale')));
        }

        $translations = Cache::remember('translations.'.$locale, now()->addMinutes(30), function () use ($path) {
            return collect(
                File::allFiles($path)
            )->flatMap(function ($file) {
                return Arr::dot(
                    File::getRequire($file->getRealPath()),
                    $file->getBasename('.'.$file->getExtension()).'.'
                );
            });
        });

        return $translations;
    }
}
