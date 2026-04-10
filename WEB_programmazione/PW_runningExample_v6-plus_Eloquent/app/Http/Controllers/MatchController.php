<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class MatchModelController extends Controller
{
    /**
     * Elenco di tutte le partite.
     */
    public function index()
    {
        $matches = MatchModel::with('host')->get();
        return view('match.index')->with('matches', $matches);
    }

    /**
     * Mostra il form per creare una nuova partita.
     */
    public function create()
    {
        return view('match.create');
    }

    /**
     * Salva una nuova partita.
     */
    public function store(Request $request)
    {
        $request->validate([
            'min_players' => 'required|integer|min:1|max:10',
            'max_players' => 'required|integer|min:1|max:10',
            'duration_hours' => 'required|in:24,48,72',
        ]);

        $match = MatchModel::create([
            'host_id' => Auth::id(),
            'min_players' => $request->input('min_players'),
            'max_players' => $request->input('max_players'),
            'duration_hours' => $request->input('duration_hours'),
        ]);

        // Aggiunge l'host automaticamente alla lista dei partecipanti con stato "accepted"
        $match->players()->attach(Auth::id(), ['status' => 'accepted']);

        return Redirect::route('matches.show', $match->id);
    }

    /**
     * Mostra una partita specifica.
     */
    public function show($id)
    {
        $match = MatchModel::with(['host', 'players'])->find($id);

        if (!$match) {
            return view('errors.wrongID')->with('message', 'Partita non trovata.');
        }

        return view('match.show')->with('match', $match);
    }

    /**
     * Avvia la partita e assegna il ruolo "hunter".
     */
    public function start($id)
    {
        $match = MatchModel::with('players')->find($id);

        if (!$match || $match->started_at) {
            return Redirect::back()->with('error', 'Partita non valida o già iniziata.');
        }

        $participants = $match->players()->wherePivot('status', 'accepted')->get();

        if ($participants->count() < $match->min_players) {
            return Redirect::back()->with('error', 'Non ci sono abbastanza giocatori per iniziare.');
        }

        // Seleziona un hunter casuale tra i partecipanti (compreso l'host)
        $hunter = $participants->random();

        $match->hunter_id = $hunter->id;
        $match->started_at = now();
        $match->save();

        return Redirect::route('matches.show', $match->id)->with('success', 'Partita iniziata!');
    }

    /**
     * Richiesta di partecipazione a una partita tramite codice.
     */
    public function joinByCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $match = MatchModel::where('code', strtoupper($request->code))->first();

        if (!$match) {
            return Redirect::back()->with('error', 'Codice partita non valido.');
        }

        // L'utente richiede di unirsi; l'host deve approvare
        $match->players()->syncWithoutDetaching([
            Auth::id() => ['status' => 'pending']
        ]);

        return Redirect::route('matches.show', $match->id)->with('success', 'Richiesta di partecipazione inviata.');
    }

    /**
     * L'host accetta un giocatore nella partita.
     */
    public function approvePlayer($matchId, $userId)
    {
        $match = MatchModel::find($matchId);

        if ($match && $match->host_id === Auth::id()) {
            $match->players()->updateExistingPivot($userId, ['status' => 'accepted']);
            return Redirect::back()->with('success', 'Giocatore approvato.');
        }

        return Redirect::back()->with('error', 'Operazione non autorizzata.');
    }

    /**
     * Mostra il tempo rimanente per una partita.
     */
    public function countdown($id)
    {
        $match = MatchModel::find($id);

        if (!$match || !$match->started_at) {
            return response()->json(['error' => 'Partita non avviata'], 400);
        }

        return response()->json([
            'seconds_remaining' => $match->timeRemaining(),
        ]);
    }
}
