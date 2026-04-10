<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createUsers();
        $this->populateHotelsAndReviews();
    }

    private function createUsers(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Devis Bianchini',
            'email' => 'devis.bianchini@unibs.it',
            'password' => Hash::make('bianchini'),
            'role' => 'admin'
        ]);

 User::factory()->create([
            'name' => 'Davide Bianchini',
            'email' => 'davide.bianchini@unibs.it',
            'role' => 'registered_user',
            'password' => Hash::make('bianchini')
        ]);

        // 19 registered users
        User::factory()->count(19)->create([
            'role' => 'registered_user',
            'password' => Hash::make('bianchini')
        ]);
    }

    private function populateHotelsAndReviews(): void
    {
        // Crea 10 hotel
        $hotels = Hotel::factory()->count(10)->create();

        // Recupera tutti gli utenti "registered_user"
        $users = User::where('role', 'registered_user')->get();

        foreach ($users as $user) {
            // Seleziona 3 hotel diversi da recensire
            $hotelsToReview = $hotels->random(3);

            foreach ($hotelsToReview as $hotel) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'hotel_id' => $hotel->id
                ]);
            }
        }
    }
}