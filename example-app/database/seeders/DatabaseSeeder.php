<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserRoleSeeder::class,
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
