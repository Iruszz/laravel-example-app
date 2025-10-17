<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::with(['user', 'agent'])->get();

        foreach ($tickets as $ticket) {
            if (!$ticket->agent) {
                continue;
            }

            $senders = [
                ['user_id' => $ticket->user_id, 'recipient_id' => $ticket->agent->id],
                ['user_id' => $ticket->agent->id, 'recipient_id' => $ticket->user_id],
                ['user_id' => $ticket->user_id, 'recipient_id' => $ticket->agent->id],
                ['user_id' => $ticket->agent->id, 'recipient_id' => $ticket->user_id],
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