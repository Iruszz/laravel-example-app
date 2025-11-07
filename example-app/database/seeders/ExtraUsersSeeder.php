<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ExtraUsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $roles = UserRole::where('name', '!=', 'Admin')->pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
                'user_role_id' => $faker->randomElement($roles),
                'phone' => '06' . $faker->numerify('########'),
            ]);
        }
    }
}

