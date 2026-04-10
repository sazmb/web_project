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

     if ($request->ajax()) {
        // Richiesta AJAX per il punteggio medio
        return $this->ajaxPunteggioMedio();
    }

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



    public function ajaxPunteggioMedioTotale()
{
    Log::debug('Chiamata AJAX per il punteggio medio ricevuta');
    $dl = new DataLayer();
    $squadre = $dl->listSquadre(); // Assicurati che questo metodo esista nel tuo DataLayer

    if (count($squadre) === 0) {
        return response()->json(['media' => 'Nessuna squadra trovata']);
    }

    $totalePunti = array_sum(array_map(fn($s) => $s->punteggio, $squadre->toArray()));
    $totalePartite = array_sum(array_map(fn($s) => $s->partite_giocate, $squadre->toArray()));

    $media = $totalePartite > 0 ? round($totalePunti / $totalePartite, 2) : 0;

    return response()->json(['media' => $media]);
}


 public function ajaxPunteggioMedio(){
    Log::debug('Chiamata AJAX per il punteggio medio ricevuta');
$dl = new DataLayer();
$squadre = $dl->listSquadre(); // Assicurati che le squadre abbiano campi: gol_fatti, gol_subiti, partite_giocate

if (count($squadre) === 0) {
    return response()->json(['media' => 'Nessuna squadra trovata']);
}

 $squadreArray = [];
Log::debug('squadre_prima_calcolo_media', $squadre->toArray());
    foreach ($squadre as $s) {
        $partite = $s->partite_giocate ?? 0;

        if ($partite === 0) {
            $mediaFatti = 0;
            $mediaSubiti = 0;
        } else {
            $golFattiTotali = rand(10, 50);
            $golSubitiTotali = rand(5, 45);

            $mediaFatti = round($golFattiTotali / $partite, 2);
            $mediaSubiti = round($golSubitiTotali / $partite, 2);
        }

        $squadreArray[] = [
            'name' => $s->name ?? 'Sconosciuta',
            'partite_giocate' => $s->partite_giocate,
            'media_gol_fatti' => $mediaFatti,
            'media_gol_subiti' => $mediaSubiti,
        ];
    }
   Log::debug('squadre_dopo_calcolo_media', $squadreArray);
    return response()->json([
        'success' => true,
        'squadre' => $squadreArray
    ]);


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
