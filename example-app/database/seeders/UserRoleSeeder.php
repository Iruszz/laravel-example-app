<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: kan allemaal in 1 gezamelijk array
        $roles = ['Admin']; // one admin role

        // generate 10 random role names
        $baseRoles = [
            'Manager',
            'Team Lead',
            'Project Coordinator',
            'Software Engineer',
            'Frontend Developer',
            'Backend Developer',
            'UX Designer',
            'QA Tester',
            'HR Specialist',
            'Marketing Specialist',
        ];

        $roles = array_merge($roles, $baseRoles);

        foreach ($roles as $role) {
            UserRole::firstOrCreate(['name' => $role]);
        }
    }
}
