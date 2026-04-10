<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use App\Models\Squadra;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class SquadraController extends Controller
{

public function dispatch(Request $request) {
    Log::debug('Azione ricevuta:', ['action' => $request->input('action')]);
    $dl = new DataLayer();

    if ($request->input('action') === 'reset') {
        return $this->zero_index();// modifica il DB
    } else {
       return $this->index();   // inizializza il DB
    }

    
}

   

    public function index() {
    $dl = new DataLayer();
    $squadreList = $dl->listSquadre();
    Log::debug('Lista squadre dopo inizializzazione:', $squadreList->toArray());
    return view('tabella')->with('squadre_list', $squadreList);
    }  
  public function zero_index()
    {
        $dl = new DataLayer();
        // $booksList = $dl->listBooks();
        $squadreList = $dl->azzeraAndListSquadre();
        Log::debug('Lista squadre dopo reset:', $squadreList->toArray());
        //return view('index')->with('sl', $squadreList);
        //return Redirect::to(route('index'))->with('squadre_list', $squadreList);
        return view('tabella')->with('squadre_list', $squadreList);
    }

   /**
     * Display a listing of the resource.
     */
    /*public function index()
    {
        $dl = new DataLayer();
        // $booksList = $dl->listBooks();
        $squadreList = $dl->listSquadre();
        //Log::debug('Lista squadre inizializzazione:', $squadreList->toArray());
        //return view('index')->with('sl', $squadreList);
        //return Redirect::to(route('classifica'))->with('squadre_list', $squadreList);
        
    }*/
    
}
