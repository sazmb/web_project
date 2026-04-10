<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Http\Resources\BookResource;

class LibraryController extends Controller
{
    public function listBooks(Request $request)
    {
        // Return all books (with authors if specified in the header)
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthors();
        } else {
            $books = $dl->listBooksWithoutAuthors();
        }

        return $books;
    }

    public function listBooksPaginate(Request $request)
    {
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthorsPaginate();
        } else {
            $books = $dl->listBooksWithoutAuthorsPaginate();
        }
        return $books;
    }

    public function listBooksPaginateAndSort(Request $request)
    {
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthorsPaginateAndSorted($request->input('sort'));
        } else {
            $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        }
        return $books;
    }

    public function listBooksWithResources(Request $request)
    {
        $dl = new DataLayer();
        // Without using AuthorResource
        // $books = $dl->listBooksWithAuthorsPaginateAndSorted($request->input('sort'));
        // Using AuthorResource
        $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        return BookResource::collection($books)->toResponse($request);
    }

    public function listBookWithRsponseHeaders(Request $request)
    {
        $dl = new DataLayer();
        // Without using AuthorResource
        // $books = $dl->listBooksWithAuthorsPaginateAndSorted($request->input('sort'));
        // Using AuthorResource
        $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        $response = BookResource::collection($books)->toResponse($request);
        return $response->header('Owner', 'Devis');
    }

    public function listBooksByCategory(Request $request) {
        $dl = new DataLayer();
        $categories = $dl->listBooksByCategory();
        return $categories;
    }
}
