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
        $tickets = Ticket::with('user')->get(); // assuming Ticket has a belongsTo User
        $admin = \App\Models\User::where('is_admin', true)->inRandomOrder()->first();

        Comment::factory()->count(50)
            ->make()
            ->each(function ($comment) use ($tickets, $admin) {
                $ticket = $tickets->random();

                // 50/50 chance: comment from ticket owner or from admin
                $comment->ticket_id = $ticket->id;
                $comment->user_id = fake()->boolean
                    ? $ticket->user_id
                    : $admin->id;

                $comment->save();
            });
    }
}
