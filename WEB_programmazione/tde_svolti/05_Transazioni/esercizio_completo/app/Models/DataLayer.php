<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    /**
     * Returns the list of books, sorted by title.
     */
    public function listBooks($userID)
    {
        $booksList = Book::where('user_id',$userID)->orderBy('title','asc')->get(); 
        return $booksList;
    }
    
    public function listTrans()
    {
        $transList = Trans::orderBy('data','asc')->get(); 
        return $transList;
    }

    /**
     * Returns the author with the specified ID.
     */
    public function findAuthorById($id, $userID)
    {
        return Author::where('id', $id)
            ->where('user_id', $userID)
            ->first();
    }
    public function findTransById($id)
    {
        return Trans::where('id', $id)
            ->first();
    }

    

    /**
     * Add a new book in the database.
     */
    public function addTrans($importo,$descrizione,$data, $tipo)
    {
        $trans = new Trans;
        $trans->importo = $importo;
        $trans->descrizione = $descrizione;
        $trans->data = $data;
        $trans->tipo = $tipo;
        $trans->save();
    }

    /**
     * Edit the book with the specified ID, using the input parameters.
     */
    public function editTrans($id,$importo,$descrizione,$data,$tipo)
    {
        $trans = Trans::find($id);
        $trans->importo = $importo;
        $trans->descrizione = $descrizione;
        $trans->data = $data;
        $trans->tipo = $tipo;
        $trans->save();
    }

    /**
     * Delete the transaction associated with the specified ID.
     */
    public function deleteTrans($id) 
    {
        $trans = Trans::find($id);
        $trans->delete();
    }
    
    public function evaluateTrans()
    {
        $totale = 0;
        $translist = $this->listTrans();
        foreach ($translist as $trans) {
            if ($trans->tipo == 'spesa') {
                $totale -= $trans->importo;
            } else if ($trans->tipo == 'entrata') {
                $totale += $trans->importo;
            }
        }
        return $totale;
    }
}