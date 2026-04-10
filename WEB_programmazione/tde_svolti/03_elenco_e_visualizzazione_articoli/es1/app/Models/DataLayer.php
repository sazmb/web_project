<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    /**
     * Returns the list of books, sorted by title.
     */
    public function listBooks()
    {
        $booksList = Book::orderBy('title','asc')->get(); 
        return $booksList;
    }

   
  
    /**
     * Returns the author with the specified ID.
     */
    public function findAuthorById($id)
    {
        return Author::where('id', $id)
            ->first();
    }

    /**
     * Returns the book with the specified ID.
     */
    public function findBookById($id)
    {
        return Book::where('id', $id)->first();
    }

    /**
     * Add a new book in the database.
     */
    public function addBook($title,$authors)
    {
        $book = new Book;
        $book->title = $title;
        $book->save();
        foreach($authors as $aut) {
            $book->authors()->attach($aut);
        }
    }

    /**
     * Edit the book with the specified ID, using the input parameters.
     */
    public function editBook($id,$title,$authors)
    {
        $book = Book::find($id);
        $book->title = $title;
        $book->save();

        // Cancel the previous list of authors
        $prevAuthors = $book->authors;
        foreach($prevAuthors as $prevAuth) {
            $book->authors()->detach($prevAuth->id);
        }

        // Update the list of authors
        foreach($authors as $aut) {
            $book->authors()->attach($aut);
        }
    }

    /**
     * Delete the book associated with the specified ID.
     */
    public function deleteBook($id) 
    {
        $book = Book::find($id);
        $authors = $book->authors;
        foreach($authors as $aut) {
            $book->authors()->detach($aut->id);
        }
        $book->delete();
    }  
    
    /**
     * Returns the list of authors, sorted by last name and first name, respectively.
     */
    public function listAuthors()
    {
        $authorsList = Author::orderBy('lastname','asc')->orderBy('firstname','asc')->get();
        return $authorsList;
    }

    public function findAuthorsByBook($bookId)
    {
         $book = Book::find($bookId);
        return $book ? $book->authors : collect(); 
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