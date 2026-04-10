<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $table = "book";
    // protected $primaryKey = 'alter_field_as_primary_key';
    // use SoftDeletes;
    // public $timestamps = false;

    protected $fillable = ['title'];

    // Method of Book model
   public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }

   

    
}
