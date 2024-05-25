<?php

namespace Database\Factories\Domain\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Tenant\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Tenant\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->colorName(),
        ];
    }
}
