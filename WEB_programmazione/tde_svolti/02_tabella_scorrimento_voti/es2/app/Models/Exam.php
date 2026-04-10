<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
     protected $fillable = ['voto', 'student_id','lode', 'data','commento'];

        public function student()
    {
        // the property $book->author returns an object of type Author
        return $this->BelongsTo(Student::class,'student_id','id');
    }
}
