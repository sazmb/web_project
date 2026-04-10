<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
      use HasFactory;
    protected $table = "reviews";
    // protected $primaryKey = 'alter_field_as_primary_key';
    // use SoftDeletes;
    // public $timestamps = false;

    // for massive assignment
    protected $fillable = ['punteggio', 'commento', 'data'];

    public function user() {
        // the property $review->user returns an object of type User
        return $this->belongsTo(User::class,'user_id','id');
    }
     public function hotel() {
        // the property $review->hotel returns an object of type Hotel
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}
