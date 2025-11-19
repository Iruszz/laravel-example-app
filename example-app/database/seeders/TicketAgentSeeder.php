<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketAgentSeeder extends Seeder
{
    public function run(): void
    {
        $admins = User::where('is_admin', true)->get();

        if ($admins->isEmpty()) {
            $this->command->info("No admins found to assign!");
            return;
        }

        // TODO: agent toekenning kan net zo goed in TicketSeeder gebeuren
        Ticket::all()->each(function ($ticket) use ($admins) {
            $ticket->agent_id = $admins->random()->id;
            $ticket->save();
        });
    }
}