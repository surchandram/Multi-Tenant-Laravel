<?php

namespace Database\Factories\Domain\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Restore\Models\OrganizationType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Tenant\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'organization_type_id' => OrganizationType::factory(),
        ];
    }
}
