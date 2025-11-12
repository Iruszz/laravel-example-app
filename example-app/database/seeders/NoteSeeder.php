<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::with('agent')
            ->whereNotNull('agent_id')
            ->get();

        foreach ($tickets as $ticket) {
            if ($ticket->agent && $ticket->agent->is_admin) {
                Note::factory()
                    ->count(5)
                    ->create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $ticket->agent_id,
                    ]);
            }
        }
    }
}
