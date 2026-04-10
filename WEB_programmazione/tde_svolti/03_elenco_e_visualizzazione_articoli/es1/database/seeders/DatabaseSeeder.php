<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\Author;
use App\Models\Book;
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


      // Crea almeno 10 autori
        $authors = Author::factory()->count(10)->create();

        // Crea almeno 10 libri
        $books = Book::factory()->count(10)->create();

        // Crea relazioni molti-a-molti
        foreach ($authors as $author) {
            // Ogni autore avrà da 1 a 5 libri casuali
            $bookIds = $books->random(rand(1, 5))->pluck('id')->toArray();

            // Associa i libri all'autore (molti-a-molti)
            $author->books()->attach($bookIds);}

     
    }

   

    
}
