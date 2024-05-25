<?php

namespace Database\Factories\Domain\WebApps\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use SAAS\Domain\WebApps\Models\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\WebApps\Models\App>
 */
class AppFactory extends Factory
{
    protected $model = App::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ($name = $this->faker->unique()->colorName),
            'key' => Str::snake($name),
            'description' => $this->faker->text(300),
            'url' => $this->faker->unique()->slug(1),
            'usable' => $this->faker->randomElement([true, false]),
            'primary' => $this->faker->randomElement([true, false]),
            'subscription' => $this->faker->randomElement([true, false]),
        ];
    }
}
