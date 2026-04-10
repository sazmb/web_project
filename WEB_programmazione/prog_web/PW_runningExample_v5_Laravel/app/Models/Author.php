<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{


    protected $table = 'author';
    // protected $timestamps = 'false';
    use HasFactory;
    public function book(){
        return $this->hasMany(Book::class, 'author_id', 'id');
    }
    
    
}