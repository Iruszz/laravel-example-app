<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            NormalUsersSeeder::class,
            ExtraUsersSeeder::class,
            AdminSeeder::class, 
            StatusSeeder::class,
            CategorySeeder::class,
            TicketSeeder::class,
            TicketAgentSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
