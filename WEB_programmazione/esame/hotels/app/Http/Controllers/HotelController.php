<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    public function index()
    {
        Log::info('Displaying the list of hotels');
        $dl = new DataLayer();
        $hotelsList = $dl->listHotels();
        return view('hotel.hotels')->with('hotels_list', $hotelsList);
    }

    public function create()
    {
        Log::info('Creating a new hotel');
        return view('hotel.editHotel');
    }

    public function store(Request $request)
    {
        $dl = new DataLayer();
        $dl->addHotel(
            $request->input('nome'),
            $request->input('descrizione'),
            $request->input('localita'),
            $request->input('immagine')
        );

        return Redirect::to(route('hotel.index'));
    }

    public function show(string $id)
    {
        Log::info('Displaying the details of a hotel');
        $dl = new DataLayer();
        $hotel = $dl->findHotelById($id);

        if ($hotel !== null) {
            return view('hotel.details')->with('hotel', $hotel);
        } else {
            return view('errors.wrongID')->with('message', 'Wrong hotel ID has been used!');
        }
    }

   public function findHotelById(string $id)
{
    Log::info('Finding hotel by ID');
    $dl = new DataLayer();
    return $dl->findHotelById($id);
}
}