<?php

namespace Database\Factories\Domain\Features\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Features\Models\Feature;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Features\Models\Feature>
 */
class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->colorName(),
            'key' => $this->faker->unique()->slug(1),
            'usable' => $this->faker->unique()->randomElement([true, false]),
        ];
    }
}
