<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    /**
     * Returns the list of books, sorted by title.
     */
    public function listBooks($userID)
    {
        $booksList = Book::where('user_id',$userID)->orderBy('title','asc')->get(); 
        return $booksList;
    }

     /**
     * Returns the list of squadre, sorted by title.
     */

    public function listSquadre()
    {
        $squadreList = Squadra::orderByDesc('punteggio')->orderBy('name')->get(); 
        $giornate=rand(0,6);
        foreach($squadreList as $squadra) {
         
            $squadra->partite_giocate =$giornate; 
           
        }
        return $squadreList;
    }
    public function azzeraAndListSquadre()
    {
        $squadreList = Squadra::orderBy('name')->get(); 
        foreach($squadreList as $squadra) {
            $squadra->punteggio = 0;
            $squadra->partite_giocate = 0;
            $squadra->vittorie = 0;
            $squadra->pareggi = 0;
            $squadra->sconfitte = 0;
            $squadra->save();
        }
        return $squadreList;
    }


    /**
     * Returns the author with the specified ID.
     */
    public function findAuthorById($id, $userID)
    {
        return Author::where('id', $id)
            ->where('user_id', $userID)
            ->first();
    }

    /**
     * Returns the book with the specified ID.
     */
    public function findBookById($id, $userID)
    {
        return Book::where('id', $id)
            ->where('user_id', $userID)
            ->first();
    }

    /**
     * Add a new book in the database.
     */
    public function addBook($title,$author_id,$categories, $userID)
    {
        $book = new Book;
        $book->title = $title;
        $book->author_id = $author_id;
        $book->user_id = $userID;
        $book->save();
        foreach($categories as $cat) {
            $book->categories()->attach($cat);
        }
    }

    /**
     * Edit the book with the specified ID, using the input parameters.
     */
    public function editBook($id,$title,$author_id,$categories)
    {
        $book = Book::find($id);
        $book->title = $title;
        $book->author_id = $author_id;
        $book->save();

        // Cancel the previous list of categories
        $prevCategories = $book->categories;
        foreach($prevCategories as $prevCat) {
            $book->categories()->detach($prevCat->id);
        }

        // Update the list of categories
        foreach($categories as $cat) {
            $book->categories()->attach($cat);
        }
    }

    /**
     * Delete the book associated with the specified ID.
     */
    public function deleteBook($id) 
    {
        $book = Book::find($id);
        $categories = $book->categories;
        foreach($categories as $cat) {
            $book->categories()->detach($cat->id);
        }
        $book->delete();
    }  
    
    /**
     * Returns the list of authors, sorted by last name and first name, respectively.
     */
    public function listAuthors($userID)
    {
        $authorsList = Author::where('user_id',$userID)->orderBy('lastname','asc')->orderBy('firstname','asc')->get();
        return $authorsList;
    }
    
    /**
     * Add a new author in the database.
     */
    public function addAuthor($first_name,$last_name,$userID)
    {
        $author = new Author;
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->user_id = $userID;
        $author->save();

        //use the factory to randomly generate an address
        Address::factory()->count(1)->create(['author_id' => $author->id]);
    }  

    /**
     * Edit the author with the specified ID, using the input parameters.
     */
    public function editAuthor($id,$first_name,$last_name)
    {
        $author = Author::find($id);
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->save();
    }

    /**
     * Delete the author associated with the specified ID.
     */
    public function deleteAuthor($id) 
    {
        $author = Author::find($id);
        $author->address->delete();
        $author->delete();
    }

    /**
     * Retrieves all the categories in the database.
     */
    public function getAllCategories() {
        return Category::orderBy('name','asc')->get();
    }

    public function findBookByTitle($title) {
        $books = Book::where('title',$title)->get();

        if(count($books) === 0)
        {
            return false;
        } else {
            return true;
        }
    }

    public function findAuthorByNames($first_name,$last_name) {
        //$authors = DB::select('select * from author where (firstname = ? AND lastname = ?)',[$first_name,$last_name]);
        $authors = Author::where('firstname', $first_name)
                 ->where('lastname', $last_name)
                 ->get();

        if(count($authors) === 0)
        {
            return false;
        } else {
            return true;
        }
    }

    public function findUserByemail($email) {
        $users = User::where('email', $email)->get();
        
        if (count($users) == 0) {
            return false;
        } else {
            return true;
        }
    }
}