<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::with('user')->get();
        $adminId = 2; // Specific admin user_id

        foreach ($tickets as $ticket) {
            // Alternate sender: user, admin, user, admin
            $senders = [
                ['user_id' => $ticket->user_id, 'recipient_id' => $adminId],
                ['user_id' => $adminId, 'recipient_id' => $ticket->user_id],
                ['user_id' => $ticket->user_id, 'recipient_id' => $adminId],
                ['user_id' => $adminId, 'recipient_id' => $ticket->user_id],
            ];

            foreach ($senders as $sender) {
                $comment = \App\Models\Comment::factory()->make([
                    'ticket_id' => $ticket->id,
                    'user_id' => $sender['user_id'],
                    'recipient_id' => $sender['recipient_id'],
                ]);
                $comment->save();
            }
        }
    }
}
