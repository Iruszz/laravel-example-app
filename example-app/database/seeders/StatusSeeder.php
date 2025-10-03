<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending', 'color' => 'yellow-500'],
            ['name' => 'solved',  'color' => 'green-500'],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(
                ['name' => $status['name']],
                ['color' => $status['color']]
            );
        }
    }
}
