<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    use Hasfactory;
          protected $fillable = ['student_id','first_name', 'last_name', 'voto', 'data'];

}
