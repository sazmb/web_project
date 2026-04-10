<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;
    protected $table = "hotels";
    // protected $primaryKey = 'alter_field_as_primary_key';
    // use SoftDeletes;
    // public $timestamps = false;

    // for massive assignment
    protected $fillable = ['nome', 'descrizione', 'localita', 'immagine'];

    // Method of Hotel model

    public function reviews()
    {
        // the property $hotel->reviews returns an array of Reviews
        return $this->hasMany(Review::class,'hotel_id','id');
    }
   
}
