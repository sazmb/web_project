<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datalayer as DataLayer;
use Illuminate\Support\Facades\Log;

class SaveController extends Controller
{
    public function salva(Request $request)

{
    Log::info('Valore del campo azione:', ['azione' => $request->input('azione')]);
    // Esempio: logica di salvataggio
    if ($request->input('azione') === 'invia') {
      
         $nome = $request->input('nome');
         $cognome = $request->input('cognome');
    $matricola = $request->input('matricola');
    $voto = $request->input('voto');
    $lode = $request->boolean('lode'); // restituisce true/false
    $dataEsame = $request->input('data_esame');
    $commenti = $request->input('commenti');

    $sc=new StudentController();
    $ec=new ExamController();
   

    $firstTimeStudent= $sc->hasPositiveVote($matricola);
    Log::info('firstTimeStudent = ' . ($firstTimeStudent ? 'true' : 'false'));
    
        if ($firstTimeStudent === false) {
Log::info('qui ce entra: +  ');
            $sc ->store($nome,$cognome, $matricola);
            $ec->store($matricola, $voto, $dataEsame, $lode, $commenti);
            
            return redirect('/')->with('message', 'Voto salvato correttamente!');
        }elseif ($firstTimeStudent && $voto<= 17) {
            Log::info('qui ce entra:  ho voti ma non positivi+  ');
             $ec->store($matricola, $voto, $dataEsame, $lode, $commenti);
             return redirect('/')->with('message', 'Voto salvato correttamente!, ma lo studente ha gia superato un esame');
    } 
    else {   Log::info('qui ce entra:  ho voti positivo+  ');
        return redirect('/')->with('message', 'Voto non salvato, lo studente non puo avere due esami con voto minore di 18');
    }
    
}elseif ($request->input('azione') === 'cancella')
     {
      // return view('index')->with('message','opreazione annullata');
       return redirect('/')->with('message', 'opreazione annullata');
    }

    // return view(...), redirect(...), ecc.
}


public function ajaxStats()
{
    $dl = new DataLayer();
    $response =$dl->statistiche();
   Log::info('firstTimeStudent = ' . print_r($response, true));
    return response()->json($response);
   
}

}