<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trans>
 */
class TransFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'importo' => $this->faker->randomFloat(2, 0, 1000),
            'descrizione' => $this->faker->sentence,
            'data' => $this->faker->date,
            'tipo' => $this->faker->randomElement(['entrata', 'spesa'])
        ];
    }
}
