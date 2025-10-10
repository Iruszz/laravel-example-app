<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $normalUsers = User::where('is_admin', false)->get();

        foreach ($normalUsers as $user) {
            // Assign between 1 and 5 tickets randomly
            $ticketCount = rand(1, 5);

            Ticket::factory()->count($ticketCount)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
