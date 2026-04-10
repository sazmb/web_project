<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    protected $table = 'author';
    // protected $primaryKey = 'alter_field_as_primary_key';
    // use SoftDeletes;
    // public $timestamps = false;

    protected $fillable = ['firstname', 'lastname',  'email',];

    // Method of Author model
    public function books()
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }

 
}
