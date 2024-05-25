<?php

namespace Database\Factories\Domain\Companies\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\User;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            // 'personal_team' => true,
        ];
    }
}
