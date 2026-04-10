<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;

use App\Models\Book;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class TransController extends Controller
{  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Displaying the list of transactions');
        $dl = new DataLayer();
        // $booksList = $dl->listBooks();
        $transList = $dl->listTrans();
        return view('trans.trans')->with('trans_list',$transList);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        log::info('Creating a new transaction');
        $dl = new DataLayer();
        return view('trans.editTrans');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // echo "Store a newly created resource in storage";
        // abort(501);
        $dl = new DataLayer();
        $dl->addTrans($request->input('importo'), 
        $request->input('descrizione'), $request->input('data'), $request->input('tipo_transazione'));

        return Redirect::to(route('trans.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Log::info('Displaying the details of a transaction');
        $dl = new DataLayer();
        $trans = $dl->findTransById($id);

        if ($trans !== null) {
            return view('trans.details')->with('trans',$trans);
        } else {
            return view('errors.wrongID')->with('message','Wrong transaction ID has been used!');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Log::info('Displaying the form for editing a transaction');
        $dl = new DataLayer();
        $trans = $dl->findTransById($id);

        if ($trans !== null) {
            return view('trans.editTrans')->with('trans', $trans);
        } else {
            return view('errors.wrongID')->with('message','Wrong transaction ID has been used!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // echo "Update the specified resource in storage";
        // abort(501);
        $dl = new DataLayer();
        $dl->editTrans($id, $request->input('importo'), $request->input('descrizione'), $request->input('data'), $request->input('tipo'));
        return Redirect::to(route('trans.index'));
    }

    public function confirmDestroy($id)
    {
        Log::info('Displaying the confirmation for deleting a transaction');
        $dl = new DataLayer();
        $trans = $dl->findTransById($id);
        if ($trans !== null) {
            return view('trans.deleteTrans')->with('trans', $trans);
        } else {
            return view('errors.wrongID')->with('message','Wrong transaction ID has been used!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // echo "Remove the specified resource from storage";
        // abort(501);
        $dl = new DataLayer();
        $dl->deleteTrans($id);
        return Redirect::to(route('trans.index'));
    }
    

    public function ajaxCalcolaSomma() {
        $dl = new DataLayer();
        $somma = $dl->evaluateTrans();
        
        return response()->json(['somma' => $somma]);
    }
    /*
    * questo metodo serve per verificare se esiste una transazione con il titolo specificato
    * e viene chiamato tramite una richiesta AJAX
    */
     /*public function ajaxCheckForBooks(Request $request) {
        $dl = new DataLayer();

        if($dl->findTransByTitle($request->input('title')))
        {
            $response = array('found' => true);
        } else {
            $response = array('found' => false);
        }
        return response()->json($response);
    }*/
}
