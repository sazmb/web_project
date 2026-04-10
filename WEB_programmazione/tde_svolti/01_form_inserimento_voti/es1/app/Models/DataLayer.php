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
        $booksList = Exam::orderBy('student_id','asc')->get(); 
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
   
}