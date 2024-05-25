<?php

namespace SAAS\App\ValueObjects;

class ConvertTemperature
{
    /**
     * Convert Fahrenheit to Celsius.
     *
     * @param  float  $fahrenheit
     * @return float
     */
    public static function toCelsius($fahrenheit)
    {
        return ($fahrenheit - 32) * (5 / 9);
    }

    /**
     * Convert Celsius to Fahrenheit.
     *
     * @param  float  $celsius
     * @return float
     */
    public static function toFahrenheit($celsius)
    {
        return ($celsius * (9 / 5)) + 32;
    }
}
