<?php

namespace Database\Factories\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Restore\Models\PsychrometryReport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Restore\Models\PsychrometryReport>
 */
class PsychrometryReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PsychrometryReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'temperature' => fake()->biasedNumberBetween(70, 212),
            'relative_humidity' => fake()->biasedNumberBetween(),
            'recorded_at' => fake()->dateTimeBetween('-3 days'),
        ];
    }
}
