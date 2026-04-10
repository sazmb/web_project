<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\Author;
use App\Models\Book;
use App\Models\Trans;
use App\Models\DataLayer;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $this->populateDB();
    }

    private function populateDB()
    {

        Trans::factory()->count(10)->create();
    }

   

    private function createUsers() {

        User::factory()->create([
            'name' => 'Devis Bianchini',
            'email' => 'devis.bianchini@unibs.it',
            'password' => Hash::make('bianchini'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Davide Bianchini',
            'email' => 'davide.bianchini@unibs.it',
            'password' => Hash::make('bianchini')
        ]);

        User::factory()->create([
            'name' => 'Alessandro Bianchini',
            'email' => 'alessandro.bianchini@unibs.it',
            'password' => Hash::make('bianchini')
        ]);
    }
}
