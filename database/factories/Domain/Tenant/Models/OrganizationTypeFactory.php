<?php

namespace Database\Factories\Domain\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Tenant\Models\OrganizationType>
 */
class OrganizationTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->jobTitle(),
        ];
    }
}
