<?php

namespace App\Http\Controllers;
use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\log;
use App\Models\Student;

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

    public function destroy($id)
{   

    //attenzione id passato in realta' è lo student_id, non l'id del modello
    // quindi dobbiamo trovare lo studente con lo student_id
    // e poi eliminarlo
    $dl = new DataLayer();

    $studentId = $dl->findStudentbyId($id)->id; // id passato è lo student_id
    $student = Student::findOrFail($studentId);

// 🔸 Log dell'operazione di eliminazione
Log::info('Studente eliminato', [
    'student_id' => $student->id,
    'name' => $student->name,
    'email' => $student->email,
    'deleted_at' => now(),
    'performed_by' => auth()->user()->id ?? 'system' // opzionale: ID dell’utente che ha eseguito l’azione
]);

$student->delete();

return response()->json(['message' => 'Eliminato con successo']);
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
    Log::info('firstTimeStudent = ciao sono in getSingleStudent');
   return response()->json([
        'data' => $esame->data,
        'student_id' => $esame->student_id,
        'last_name' => $esame->last_name,
        'first_name' => $esame->first_name,
        'voto' => $esame->voto
    ]);
}
}