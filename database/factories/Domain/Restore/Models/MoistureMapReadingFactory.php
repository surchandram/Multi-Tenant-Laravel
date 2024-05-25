<?php

namespace Database\Factories\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\MoistureMapReading;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Restore\Models\MoistureMapReading>
 */
class MoistureMapReadingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MoistureMapReading::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'moisture_map_id' => MoistureMap::factory(),
            'value' => fake()->biasedNumberBetween(),
            'recorded_at' => fake()->dateTimeBetween('-3 days'),
        ];
    }
}
