<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\UserRole;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = UserRole::where('name', 'Admin')->first();
        $faker = Faker::create();

        $admins = [
            ['name' => 'Admin One', 'email' => 'admin1@example.com'],
            ['name' => 'Admin Two', 'email' => 'admin2@example.com'],
            ['name' => 'Admin Three', 'email' => 'admin3@example.com'],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('password'),
                    'is_admin' => true,
                    'email_verified_at' => now(),
                    'user_role_id' => $adminRole->id,
                    'phone' => '06' . $faker->numerify('########'),
                ]
            );
        }
    }
}
