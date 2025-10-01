<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ticket = \App\Models\Ticket::inRandomOrder()->first();
        $adminId = 2;
        $userId = $ticket ? $ticket->user_id : null;

        // Default: user sends to admin
        $user_id = $userId;
        $recipient_id = $adminId;

        // If factory is called with user_id = 2, send to ticket owner
        if (isset($this->attributes['user_id']) && $this->attributes['user_id'] == $adminId) {
            $user_id = $adminId;
            $recipient_id = $ticket ? $ticket->user_id : null;
        }

        return [
            'comment' => fake()->paragraph(),
            'ticket_id' => $ticket ? $ticket->id : null,
            'user_id' => $user_id,
            'recipient_id' => $recipient_id,
        ];
    }
}
