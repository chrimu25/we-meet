<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coordinator>
 */
class CoordinatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prefix'=> $this->faker->randomElement(['Mr.', 'Mrs.', 'Ms.', 'Dr.']),
            'phone'=> $this->faker->phoneNumber,
            'user_id'=>User::factory([
                'role'=>'Coordinator'
            ]),
        ];
    }
}
