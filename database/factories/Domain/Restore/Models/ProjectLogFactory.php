<?php

namespace Database\Factories\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Restore\Models\ProjectLog;
use SAAS\Domain\Users\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Restore\Models\ProjectLog>
 */
class ProjectLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => fake()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
