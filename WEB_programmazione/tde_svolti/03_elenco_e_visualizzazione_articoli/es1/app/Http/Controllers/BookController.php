<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dl = new DataLayer();
        // $booksList = $dl->listBooks();
        $booksList = $dl->listBooks();
        return view('book.index')->with('books_list', $booksList);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dl = new DataLayer();
        $authorsList = $dl->findAuthorsByBook($id);
         Log::info('Autori trovati per il libro ID ' . $id, ['authorsList' => $authorsList]);
        if ($authorsList === null) {
            return response()->json([
                'success' => false,
                'authors' => $authorsList
            ]);
        } else {
            return response()->json([
                'success' => true,
                'authors' => $authorsList
            ]);
        }
    }
    /*
    public function create()
    {
        $dl = new DataLayer();
        $authorList = $dl->listAuthors();
       // return view('book.editBook')->with('authorList',$authorList)->with('categories',$categories);
        return view('book.editBook')->with('authorList',$authorList);
    }


    public function store(Request $request)
    {
        // echo "Store a newly created resource in storage";
        // abort(501);
        $selectedCategories = $request->input('categories',[]);
        $dl = new DataLayer();
        $dl->addBook($request->input('title'), 
        $request->input('author_id'));

        return Redirect::to(route('book.index'));
    }




    public function edit(string $id)
    {
        $dl = new DataLayer();
        $authorList = $dl->listAuthors();
        $book = $dl->findBookById($id);


        if ($book !== null) {
            return view('book.editBook')->with('authorList', $authorList)->with('book', $book);
        } else {
            return view('errors.wrongID')->with('message','Wrong book ID has been used!');
        }
    }


    public function update(Request $request, string $id)
    {
        // echo "Update the specified resource in storage";
        // abort(501);
        $selectedCategories = $request->input('categories',[]);
        $dl = new DataLayer();
        $dl->editBook($id, $request->input('title'), $request->input('author_id'));
        return Redirect::to(route('book.index'));
    }

    public function confirmDestroy($id)
    {
        $dl = new DataLayer();
        $book = $dl->findBookById($id);
        if ($book !== null) {
            return view('book.deleteBook')->with('book', $book);
        } else {
            return view('errors.wrongID')->with('message','Wrong book ID has been used!');
        }
    }


    public function destroy(string $id)
    {
        // echo "Remove the specified resource from storage";
        // abort(501);
        $dl = new DataLayer();
        $dl->deleteBook($id);
        return Redirect::to(route('book.index'));
    }

    public function ajaxCheckForBooks(Request $request) {
        $dl = new DataLayer();

        if($dl->findBookByTitle($request->input('title')))
        {
            $response = array('found' => true);
        } else {
            $response = array('found' => false);
        }
        return response()->json($response);
    }
    */
}
