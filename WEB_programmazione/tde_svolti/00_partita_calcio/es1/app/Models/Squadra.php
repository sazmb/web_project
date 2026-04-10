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
    public function calcolaPunteggio()
    {
        return ($this->vittorie * 3) + $this->pareggi;
    }

    // Metodo per inizializzare i dati in modo casuale
    public static function inizializzaSquadreCasualmente($numeroSquadre)
    {
        $nomi = ['Juventus', 'Milan', 'Inter', 'Roma', 'Napoli', 'Lazio', 'Atalanta', 'Fiorentina', 'Torino', 'Sampdoria'];

        shuffle($nomi);

        foreach (array_slice($nomi, 0, $numeroSquadre) as $nome) {
            $x = rand(0, 38);
            $v = rand(0, $x);
            $n = rand(0, $x - $v);
            $p = $x - $v - $n;

            $squadra = new Squadra([
                'nome' => $nome,
                'partite_giocate' => $x,
                'vittorie' => $v,
                'pareggi' => $n,
                'sconfitte' => $p,
                'punteggio' => (3 * $v + $n),
            ]);

            $squadra->save();
        }
    }

    // Scope per ordinamento
    public function scopeOrdinaPerPunteggio($query)
    {
        return $query->orderByDesc('punteggio')->orderBy('nome');
    }
}
