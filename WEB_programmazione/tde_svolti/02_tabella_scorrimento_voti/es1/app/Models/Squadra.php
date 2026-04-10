<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class Squadra extends Model
{
    //
    use HasFactory;
    protected $table = "squadras";

    protected $fillable = ['nome', 'partite_giocate', 'vittorie', 'pareggi', 'sconfitte', 'punteggio'];

    // Calcolo punteggio automatico
   

    
}
