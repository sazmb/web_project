<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company . ' Hotel',
            'descrizione' => $this->faker->paragraph(3),
            'localita' => $this->faker->city,
            'immagine' => $this->faker->imageUrl(640, 480, 'hotels', true), // immagine casuale
        ];
    }
}

