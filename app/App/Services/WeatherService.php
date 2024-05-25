<?php

namespace SAAS\App\Services;

use GuzzleHttp\Client;
use SAAS\App\ValueObjects\ConvertTemperature;

class WeatherService
{
    /**
     * The OpenWeatherMap API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Guzzle HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The country for the weather data.
     *
     * @var string
     */
    protected $country;

    /**
     * The state for the weather data.
     *
     * @var string
     */
    protected $state;

    /**
     * The city for the weather data.
     *
     * @var string
     */
    protected $city;

    /**
     * The postal code for the weather data.
     *
     * @var string|null
     */
    protected $postalCode;

    /**
     * The cached weather data.
     *
     * @var array
     */
    protected $weatherData;

    /**
     * Create a new WeatherService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.api_key');
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
        ]);
    }

    /**
     * Create a new WeatherService instance.
     *
     * @return static
     */
    public static function make()
    {
        return new static();
    }

    /**
     * Set the location for weather data retrieval.
     *
     * @param  string  $country
     * @param  string  $state
     * @param  string  $city
     * @param  string|null  $postalCode
     * @return $this
     */
    public function fromLocation($country, $state, $city, $postalCode = null)
    {
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Fetch weather data from the OpenWeatherMap API.
     *
     * @return array
     */
    public function fetchData()
    {
        if (! $this->weatherData) {
            $response = $this->request('weather', [
                'q' => "$this->city,$this->state,$this->country,$this->postalCode",
                'units' => 'metric',
            ]);

            $this->weatherData = $response['main'] ?? [];
        }

        return $this->weatherData;
    }

    /**
     * Get the temperature.
     *
     * @param  bool  $inCelsius
     * @return float|null
     */
    public function temperature($inCelsius = false)
    {
        $data = $this->fetchData();
        $temperature = $data['temp'] ?? null;

        if ($inCelsius) {
            return $temperature;
        }

        return ConvertTemperature::toFahrenheit($temperature);
    }

    /**
     * Get the humidity.
     *
     * @return int|null
     */
    public function humidity()
    {
        $data = $this->fetchData();

        return $data['humidity'] ?? null;
    }

    /**
     * Make a request to the OpenWeatherMap API.
     *
     * @param  string  $endpoint
     * @param  array  $params
     * @return array|null
     */
    protected function request($endpoint, $params)
    {
        try {
            $params['appid'] = $this->apiKey;

            $response = $this->client->get($endpoint, [
                'query' => $params,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Log or handle the error as needed
            return null;
        }
    }
}
