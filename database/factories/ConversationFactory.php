<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user1 = User::inRandomOrder()->first();
        $user2 = User::inRandomOrder()->where('id', '!=', $user1->id)->first();

        return [
            'user_id_1' => $user1->id,
            'user_id_2' => $user2->id,
        ];
    }
}
