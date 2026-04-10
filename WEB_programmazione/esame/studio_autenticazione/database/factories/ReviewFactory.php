<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'punteggio' => $this->faker->numberBetween(1, 5),
            'commento' => $this->faker->paragraph(),
            'data' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => User::factory(),   // Associa un nuovo utente
            'hotel_id' => Hotel::factory(), // Associa un nuovo hotel
        ];
    }
}

