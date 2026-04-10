<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    /**
     * Restituisce la lista di tutti gli hotel, ordinata per nome.
     */
    public function listHotels()
    {
        return Hotel::orderBy('nome', 'asc')->get();
    }

    /**
     * Restituisce un hotel dato il suo ID.
     */
    public function findHotelById($id)
    {
        return Hotel::find($id);
    }

    /**
     * Aggiunge un nuovo hotel al database.
     */
    public function addHotel($nome, $descrizione, $localita, $immagine)
    {
        return Hotel::create([
            'nome' => $nome,
            'descrizione' => $descrizione,
            'localita' => $localita,
            'immagine' => $immagine
        ]);
    }

    /**
     * Modifica un hotel esistente.
     */
    public function editHotel($id, $nome, $descrizione, $localita, $immagine)
    {
        $hotel = Hotel::find($id);

        if ($hotel) {
            $hotel->update([
                'nome' => $nome,
                'descrizione' => $descrizione,
                'localita' => $localita,
                'immagine' => $immagine
            ]);
        }

        return $hotel;
    }

    /**
     * Elimina un hotel esistente (insieme alle sue recensioni).
     */
    public function deleteHotel($id)
    {
        $hotel = Hotel::find($id);

        if ($hotel) {
            $hotel->reviews()->delete(); // Elimina le recensioni collegate
            $hotel->delete();
        }

        return $hotel;
    }

    /**
     * Restituisce tutte le recensioni associate a un hotel.
     */
    public function listReviewsForHotel($hotelId)
    {
        return Review::where('hotel_id', $hotelId)->orderBy('data', 'desc')->get();
    }

    /**
     * Restituisce tutte le recensioni scritte da un utente.
     */
    public function listReviewsByUser($userId)
    {
        return Review::where('user_id', $userId)->orderBy('data', 'desc')->get();
    }

    /**
     * Restituisce una recensione per ID.
     */
    public function findReviewById($id)
    {
        return Review::find($id);
    }

    /**
     * Restituisce tutte le recensioni per un hotel specifico.
     */
    public function listReviewsByHotel($hotelId){
        return Review::where('hotel_id', $hotelId)->orderBy('data','desc')->get();
    }

    /**
     * Aggiunge una nuova recensione a un hotel.
     */
    public function addReview($punteggio, $commento, $data, $userId, $hotelId)
    {
        return Review::create([
            'punteggio' => $punteggio,
            'commento' => $commento,
            'data' => $data,
            'user_id' => $userId,
            'hotel_id' => $hotelId
        ]);
    }

    /**
     * Modifica una recensione esistente.
     */
    public function editReview($id, $punteggio, $commento, $data)
    {
        $review = Review::find($id);

        if ($review) {
            $review->update([
                'punteggio' => $punteggio,
                'commento' => $commento,
                'data' => $data
            ]);
        }

        return $review;
    }

    /**
     * Elimina una recensione.
     */
    public function deleteReview($id)
    {
        $review = Review::find($id);

        if ($review) {
            $review->delete();
        }

        return $review;
    }

    /**
     * Controlla se esiste un utente con l'email fornita.
     */
    public function findUserByEmail($email)
    {
        return User::where('email', $email)->exists();
    }

    /**
     * Restituisce tutti gli utenti con ruolo "registered_user"
     */
    public function getRegisteredUsers()
    {
        return User::where('role', 'registered_user')->get();
    }

    /**
     * Controlla se l'utente ha già recensito un hotel specifico.
     */
    public function userHasReviewedHotel($userId, $hotelId)
    {
        return Review::where('user_id', $userId)
                     ->where('hotel_id', $hotelId)
                     ->exists();
    }
}
