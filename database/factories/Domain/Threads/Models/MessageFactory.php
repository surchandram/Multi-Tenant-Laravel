<?php

namespace Database\Factories\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Threads\Models\Message;
use SAAS\Domain\Threads\Models\Thread;
use SAAS\Domain\Users\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\Threads\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'thread_id' => Thread::factory(),
            'user_id' => User::factory(),
        ];
    }
}
