<?php

namespace Database\Factories\Domain\Tenant\Models;

use Illuminate\Support\Str;
use SAAS\Domain\Tenant\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Tenant\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ($name = $this->faker->words(3, true)),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(10, true),
        ];
    }
}
