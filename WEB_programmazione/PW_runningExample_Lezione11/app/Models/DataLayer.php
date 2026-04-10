<?php

namespace App\Models;

class DataLayer
{
    /**
     * Returns the list of books, sorted by title.
     */
    public function listBooks($userID)
    {
        // una volta qui c'era la creazione diretta dei libiri ma ora si è spotato tutto in un seeder
        // in modo da automare la creazione dei libri

        $booksList = Book::where('user_id',$userID)->orderBy('title','asc')->get();
        return $booksList;

        
    }
    public function listMatches()
    {
        return MatchModel::orderBy('id', 'desc')->get();
        return $booksList;

        
    }

    /**
     * Returns the author with the specified ID.
     */
    public function findAuthorById($id)
    {
        return Author::find($id);
    }

     public function findMatchById($id)
    {
        return Author::find($id);
    }

    /**
     * Returns TRUE if a book associated with the author's ID exists, FALSE otherwise.
     * (DEPRECATED)
     */
    public function findMatchesByUserID($id)
    {
        // if($id==1)
        // {
        //     return true;
        // } elseif($id==2) 
        // {
        //     return true;
        // } else
        // {
        //     return false;
        // }
    }

    /**
     * Returns the book with the specified ID.
     */
    public function findBookById($id)
    {
        // if($id==1)
        // {
        //     return new Book(1,"Il nome della rosa","Umberto Eco",1);
        // } elseif($id==2) 
        // {
        //     return new Book(2,"IT","Stephen King",2);
        // } elseif($id==3)
        // {
        //     return new Book(3,"The tommyknockers - Le creature del buio","Stephen King",2);
        // } else
        // {
        //     return null;
        // }
        return Book::find($id);
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
        // massive creation (only with fillable property enabled on Book):
        // Book::create(['title' => $title, 'author_id' => $author_id]);
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

        // Cancel the previous list of categories pero prima lo scollego usando detach
        $prevCategories = $book->categories;
        foreach($prevCategories as $prevCat) {
            $book->categories()->detach($prevCat->id);
        }

        // Update the list of categories
        foreach($categories as $cat) {
            $book->categories()->attach($cat);
        }
        // massive update (only with fillable property enabled on Book): 
        // Book::find($id)->update(['title' => $title, 'author_id' => $author_id]);
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
        // $authorsList = array();
        // $authorsList[] = new Author(1, "Umberto", "Eco");
        // $authorsList[] = new Author(2, "Stephen", "King");
        // $authorsList[] = new Author(3, "Vito", "Mancuso");
        $authorsList = Author::wherewhere('user_id',$userID)->orderby('lastname','asc')->orderBy('firstname','asc')->get();
        return $authorsList;
    }
    
    /**
     * Add a new author in the database.
     */
    public function addAuthor($first_name,$last_name,$userID)
    {
        // $author = new Author;
        // $author->firstname = $first_name;
        // $author->lastname = $last_name;
        // $author->save();
        // massive creation (only with fillable property enabled on Author):
    {
        $author = new Author;
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->user_id = $userID;
        $author->save();

        //use the factory to randomly generate an address
        Address::factory()->count(1)->create(['author_id' => $author->id]);

        // massive creation (only with fillable property enabled on Author):
        // Author::create(['firstname' => $first_name, 'lastname' => $last_name]);
    }  
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
        // massive update (only with fillable property enabled on Author): 
        // Author::find($id)->update(['firstname' => $first_name, 'lastname' => $last_name]);
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
}