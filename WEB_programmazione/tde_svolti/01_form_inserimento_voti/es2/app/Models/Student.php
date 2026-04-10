<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
     protected $fillable = [ 'student_id','nome', 'cognome'];

     public function exam()
    {
        // the property $book->author returns an object of type Author
        return $this->hasMany(Exam::class,'student_id','id');
    }
}
