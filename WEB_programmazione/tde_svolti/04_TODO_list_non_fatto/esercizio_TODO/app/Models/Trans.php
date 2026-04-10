<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Trans extends Model
{
     use HasFactory;
    protected $table = "trans";
    // protected $primaryKey = 'alter_field_as_primary_key';
    // use SoftDeletes;
    // public $timestamps = false;
    protected $fillable = ['importo', 'descrizione','data', 'tipo'];
}
