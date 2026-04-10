<?php

namespace App\Http\Controllers;
use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\log;


class StudentController extends Controller
{

      public function index()
    {
          $dl = new DataLayer();
        // $booksList = $dl->listBooks();
        $studentList = $dl->listStudent();
        return redirect('/')->with('redirect_list',$studentList);
    }

    public function hasPositiveVote($studentId) {
        
        $dl = new DataLayer();
        return ($dl->listExamsById($studentId))->where('voto', '>', 17)->count() > 0;
        
    }
    public function edit(string $studentId)
    {
        $dl = new DataLayer();
        
        $student = $dl->findStudentbyId($studentId);
    
        if ($student !== null) {
            return redirect('/')->with('message', 'errore studente non trovato');
            
        }else {
            return redirect('/exam/edit')->with('editStudent', $student);
        }
    }

    public function update(Request $request, string $id)
    {
        // echo "Update the specified resource in storage";
        // abort(501);
        
        $dl = new DataLayer();
        $dl->editStudent($id, $request->input('first_name'),
         $request->input('last_name'),
         $request->input('voto'),
         $request->input('data'));
        return redirect('/')->with('message', 'Studente aggiornato correttamente!');
    }

      public function store($nome,$cognome, $matricola)
    {
        // echo "Store a newly created resource in storage";
        // abort(501);
       
        $dl = new DataLayer();
        $dl->addStudent($nome,$cognome, $matricola);

        
    }

     public function listaId()
{
    $dl = new DataLayer();
    $ids = $dl->listStudentId() ;
    Log::info('firstTimeStudent = ');
    return response()->json(['ids' => $ids]);
}

public function getSingleStudent($id)
{
    $dl = new DataLayer();
    $student = $dl->findStudentbyId($id);
    
    if ($student === null) {
        return redirect('/')->with('message', 'Studente non trovato');
    }
    $esame = $dl->findStudentbyId($id);
    Log::info('firstTimeStudent = ' . print_r($esame, true));
   return response()->json([
        'data' => $esame->data,
        'student_id' => $esame->student_id,
        'last_name' => $esame->last_name,
        'first_name' => $esame->first_name,
        'voto' => $esame->voto
    ]);
}
}