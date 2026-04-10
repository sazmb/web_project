<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;

class BookController extends Controller
{
    public function index()
    {
        
        $sdl = new DataLayer();
        $books_list = $sdl->listBooks();
        // Return the view with the list of books
        return view('book.books')->with('books_list', $books_list);
    }
    public function confirmDestroy(){
        // Return the view to confirm deletion of a book
        return view('book.confirmDestroy');
    }
    public function create()
    {
        // Return the view to create a new book
        return view('book.create');
    }
}
