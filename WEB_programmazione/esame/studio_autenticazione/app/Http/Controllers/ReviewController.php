<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index()
    {
        Log::info('Displaying the list of reviews for user');
        $dl = new DataLayer();
        $reviews = $dl->listReviewsByUser(auth()->user()->id);
        return view('review.reviews')->with('reviews', $reviews)->orderBy('data', 'desc');
    }

   public function findReviewByHotel($id)
{
    Log::info('Displaying the list of reviews for hotel ID: ' . $id);
    $dl = new DataLayer();
    $reviews = $dl->listReviewsByHotel($id);

    // Recupera anche l'hotel (se disponibile)
    $hotel = \App\Models\Hotel::find($id);

    // Passa sia reviews che hotel alla view
    return view('review.reviews')->with([
        'reviews' => $reviews,
        'hotel' => $hotel,
    ]);
}

   
    public function show(string $id)
    {
        Log::info('Displaying the details of a review');
        $dl = new DataLayer();
        $review = $dl->findReviewById($id);

        if ($review !== null) {
            return view('review.details')->with('review', $review);
        } else {
            return view('errors.wrongID')->with('message', 'Wrong review ID has been used!');
        }
    }


    public function ajaxCheckUserHasReviewed(Request $request)
    {
        $dl = new DataLayer();
        $exists = $dl->userHasReviewedHotel(auth()->user()->id, $request->input('hotel_id'));

        return response()->json(['hasReviewed' => $exists]);
    }
}
