<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conversation;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $conversation = Conversation::inRandomOrder()->first();
        $sender = User::inRandomOrder()->first();

        return [
            'conversation_id' => $conversation->id,
            'sender_id' => $sender->id,
            'message' => $this->faker->sentence(),
        ];
    }
}
