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

        $user_id = $userId;
        $recipient_id = $adminId;

        if (isset($this->attributes['user_id']) && $this->attributes['user_id'] == $adminId) {
            $user_id = $adminId;
            $recipient_id = $ticket ? $ticket->user_id : null;
        }

        $senderName = $user_id === $adminId ? 'Admin' : ($ticket?->user->name ?? 'User');
        $recipientName = $recipient_id === $adminId ? 'Admin' : ($ticket?->user->name ?? 'User');

        // Generate multiple sentences, each on a new line
        $sentences = $this->faker->sentences(3); // e.g. 3 sentences
        $body = implode("\n", $sentences);

        return [
            'comment' => "Dear {$recipientName},\n\n"
                       . $body . "\n\n"
                       . "Thank you,\n"
                       . "{$senderName}",
            'ticket_id' => $ticket?->id,
            'user_id' => $user_id,
            'recipient_id' => $recipient_id,
        ];
    }
}