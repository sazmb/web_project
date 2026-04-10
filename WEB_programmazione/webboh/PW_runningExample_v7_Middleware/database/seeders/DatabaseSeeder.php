<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\Author;
use App\Models\Book;
use App\Models\DataLayer;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createUsers();
        $this->populateDB();
    }

    private function populateDB()
    {

        // Create 10 book categories
        Category::factory()->count(1)->create(['name' => 'Romanzi classici']);
        Category::factory()->count(1)->create(['name' => 'Fantasy']);
        Category::factory()->count(1)->create(['name' => 'Gialli']);
        Category::factory()->count(1)->create(['name' => 'Thriller']);
        Category::factory()->count(1)->create(['name' => 'Saggi']);
        Category::factory()->count(1)->create(['name' => 'Poesie']);
        Category::factory()->count(1)->create(['name' => 'Psicologia']);
        Category::factory()->count(1)->create(['name' => 'Fantascienza']);
        Category::factory()->count(1)->create(['name' => 'Viaggi']);
        Category::factory()->count(1)->create(['name' => 'Arte e fotografia']);

        // Randomly associate a book to a subset of categories (from 1 to 5)
        $users = User::where('role', 'registered_user')->get(); // Only for registered users, not for admins
        $categories = Category::all();

        foreach($users as $user)
        {
            $this->createUserWithPersonalLibrary($user,$categories);
        }
    }

    private function createUserWithPersonalLibrary($user, $categories) {
        // Create 100 authors for the user, with their corresponding addresses
        Author::factory()->count(100)->create(['user_id' => $user->id])->each(function ($author) {
            Address::factory()->count(1)->create(['author_id' => $author->id]);
        });  

        // Randomly select a subset of 50 authors and, for each of them, create a set of books (from 1 to 5, randomly generated)
        $dl = new DataLayer();
        $authors = $dl->listAuthors($user->id);
        $authorsWithBooks = $authors->random(50);

        foreach($authorsWithBooks as $singleAuthor) {
            $numberOfBooks = rand(1,5);
            for($b=0; $b<$numberOfBooks; $b++) {
                Book::factory()->count(1)->create(['author_id' => $singleAuthor->id, 'user_id' => $user->id]);
            }
        }

        // Randomly associate a book to a subset of categories (from 1 to 5)
        $books = $dl->listBooks($user->id);

        foreach($books as $singleBook)
        {
            $numberOfCategories = rand(1,5);
            $selectedCategories = $categories->random($numberOfCategories);
            $singleBook->categories()->attach($selectedCategories);
        }        
    }

    private function createUsers() {

        User::factory()->create([
            'name' => 'Devis Bianchini',
            'email' => 'devis.bianchini@unibs.it',
            'password' => 'bianchini',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Davide Bianchini',
            'email' => 'davide.bianchini@unibs.it',
            'password' => 'bianchini'
        ]);

        User::factory()->create([
            'name' => 'Alessandro Bianchini',
            'email' => 'alessandro.bianchini@unibs.it',
            'password' => 'bianchini'
        ]);
    }
}
