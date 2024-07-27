<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $user1 = $this->faker->numberBetween(1, 50);
        $user2 = $this->faker->numberBetween(1, 50);

        while ($user1 === $user2) {
            $user2 = $this->faker->numberBetween(1, 50);
        }

        return [
            'message' => $this->faker->sentence,
            'user_id_1' => $user1,
            'user_id_2' => $user2,
        ];
    }
}
