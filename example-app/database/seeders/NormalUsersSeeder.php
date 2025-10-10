<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NormalUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            ]);
        }
    }
}