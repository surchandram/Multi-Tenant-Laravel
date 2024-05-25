<?php

namespace SAAS\App\Support;

use Illuminate\Support\Arr;
use Laraeast\LaravelSettings\DatabaseSettingsHandler;

class Settings extends DatabaseSettingsHandler
{
    /**
     * Get all settings as collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($resolved = false)
    {
        $settings = $this->settings;

        return $settings->map(function ($setting) use ($resolved) {
            $setting->type = $this->resolveKeyType($setting->key);

            // call resolved value only when resolved is true
            if ($resolved) {
                $setting->value = $this->get($setting->key);
            }

            return $setting;
        });
    }

    /**
     * Get the given item.
     *
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $instance = $this->instance($key);

        $this->locale = null;

        return ! empty($instance) ? @unserialize($instance->value) : $default;
    }

    /**
     * Get an array of cast types for setting keys.
     *
     * @return array
     */
    public function keyCastsMap()
    {
        return config('settings.casts', []);
    }

    /**
     * Resolve the given key type.
     *
     * @param  string  $key
     * @return string|null
     */
    protected function resolveKeyType($key)
    {
        return Arr::get(
            $this->keyCastsMap(),
            $key,
            config('settings.default_cast')
        );
    }
}
