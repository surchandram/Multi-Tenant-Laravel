<?php

namespace Database\Factories\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Threads\Models\Thread;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Threads\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
