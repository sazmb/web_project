<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'voto' => $this->votofake(),
            'data' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'student_id' => $this->faker->unique()->numberBetween(1000,0),
        ];
    }

     public function votofake(): int
    {
        $voto = $this->faker->numberBetween(0, 33);
        if ($voto < 18) {
            return -1; // Ensure voto is at least 18
        }elseif ($voto >30) {
            return 33; // Ensure voto does not exceed 30
        } else {
            return $voto; // Return the valid voto
        }
    }
}
