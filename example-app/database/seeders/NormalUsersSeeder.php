<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NormalUsersSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: ik zou hier een factory gebruiken en de custom data zoals name, email en password overriden:
        // User::factory()->create([
        // 'name' => 'Iris Hofman',
        // 'email' => '123@example.com',
        // 'password' => '123'
        // ]);

        $faker = Faker::create();
        $roles = UserRole::where('name', '!=', 'Admin')->pluck('id')->toArray();

        $users = [
            [
                'name' => 'Iris Hofman',
                'email' => '123@example.com',
                'password' => '123',
            ],
            [
                'name' => 'Iris Hofman2',
                'email' => '1234@example.com',
                'password' => '1234',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'is_admin' => false,
                'email_verified_at' => now(),
                'user_role_id' => $faker->randomElement($roles),
                'phone' => '06' . $faker->numerify('########'),
            ]);
        }
    }
}
