<?php

namespace App\Http\Controllers;
use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\log;


class StudentController extends Controller
{

      public function index()
    {
        //
    }

    public function hasPositiveVote($studentId) {
        
        $dl = new DataLayer();
        return ($dl->listExamsById($studentId))->where('voto', '>', 17)->count() > 0;
        
    }
      public function store($nome,$cognome, $matricola)
    {
        // echo "Store a newly created resource in storage";
        // abort(501);
       
        $dl = new DataLayer();
        $dl->addStudent($nome,$cognome, $matricola);

        
    }

}
