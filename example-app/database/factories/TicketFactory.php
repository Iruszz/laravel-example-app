<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class TicketFactory extends Factory
{
    protected $model = \App\Models\Ticket::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
