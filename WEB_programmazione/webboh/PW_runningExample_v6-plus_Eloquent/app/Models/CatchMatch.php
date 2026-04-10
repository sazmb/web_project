<?php

// app/Models/Match.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatchMatch extends Model
{
    protected $fillable = ['name', 'description', 'host_id', 'max_players'];
    
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
    
    public function players()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status')
            ->withTimestamps();
    }
    
    public function approvedPlayers()
    {
        return $this->players()->wherePivot('status', 'approved');
    }
    
    public function pendingPlayers()
    {
        return $this->players()->wherePivot('status', 'pending');
    }
    
    public function hasAvailableSlots()
    {
        return $this->approvedPlayers()->count() < $this->max_players;
    }
}