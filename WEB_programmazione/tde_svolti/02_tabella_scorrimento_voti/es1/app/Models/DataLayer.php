<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{

       public function listExamsById($userID)
    {
        $booksList = Exam::where('student_id',$userID)->orderBy('voto','asc')->get(); 
        return $booksList;
    }

     public function listExams()
    {
        $booksList = Exam::orderBy('voto','asc')->get(); 
        return $booksList;
    }

      public function listStudent()
    {
        $booksList = Student::orderBy('student_id','asc')->get(); 
        return $booksList;
    }

    public function addExam($student_id,$voto,$data, $lode, $commenti)
    {
        $exam = new Exam();
        $exam->student_id = $student_id;
        $exam->voto = $voto;
        $exam->data= $data;
        $exam->lode = $lode;
        $exam->commento= $commenti;
        $exam->save();
        
    }

    /**
     * Add a new student in the database.
     */
    public function addStudent($nome,$cognome,$student_id)
    {
        $student = new Student;
        $student->nome = $nome;
        $student->cognome = $cognome;
        $student->student_id = $student_id;
        $student->save();
    }

    public function statistiche()
{
    return [
        'totale' => Exam::count(),
        'media' => round(Exam::where('voto', '>=', 18)->avg('voto'), 2),
        'percentuale_sufficienti' => round((Exam::where('voto', '>=', 18)->count() / Exam::count()) * 100, 2),
        'max' => Exam::max('voto'),
        'min' => Exam::min('voto'),
    ];

    
} 
public function findStudentbyId($id)
    {
        return Student::where('student_id', $id)->first();
    }

    /**
     * Update the specified student in storage.
     */
 public function editStudent($id,$first_name,$last_name,$voto, $data)
    {
        $student=$this->findStudentbyId($id);
        $student->first_name = $first_name;
        $student->last_name = $last_name;
        $student->voto = $voto;
        $student->data = $data;
        $student->save();

        
    }
    public function listStudentId()
{
    return Student::orderBy('student_id')->pluck('student_id'); // oppure qualunque ordinamento tu voglia
   
}

public function getStudent($id)
{
    return Student::findOrFail($id);
   
}
   
}