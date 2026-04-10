<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Squadra;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Squadra>
 */
class SquadraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           /* 'name' => $this->faker->word,
            'partite_giocate' => $this->faker->numberBetween(1,6 ),
            'vittorie' => $this->faker->numberBetween(0, 'partite_giocate'),
            'pareggi' => $this->faker->numberBetween(0, 'partite_giocate'-'vittorie'),
            'sconfitte' => 'partite_giocate'-'vittorie'-'pareggi',
            'punteggio' => 'vittorie'*3+'pareggi', // 3 points for a win, 1 point for a draw
            */
            'name' => $this->faker->word,
            'partite_giocate' => 0,
            'vittorie' => 0,
            'pareggi' => 0,
            'sconfitte' => 0,
            'punteggio' => 0,


        ];
    }
}
