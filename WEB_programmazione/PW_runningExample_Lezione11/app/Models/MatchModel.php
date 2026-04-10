<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
       use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'host_id',
        'min_players',
        'max_players',
        'code',
        'duration_hours',
        'started_at',
        'hunter_id',
        'pending_requests', 
        'status'
    ];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    // Boot method to auto-generate code ATTENZIONE
    protected static function booted()
    {
        static::creating(function ($match) {
            // Ensure min and max player constraints
            $match->min_players = max(1, $match->min_players);
            $match->max_players = min(10, $match->max_players);

            // Generate unique code if not set
            if (empty($match->code)) {
                $match->code = Str::upper(Str::random(6));
            }
        });
    }

    /**
     * Host of the match (the creator)
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Players in the match
     */
    public function players()
    {
        return $this->belongsToMany(User::class, 'match_user', 'match_id', 'user_id')
                    ->withPivot('status'); // e.g., status: pending, accepted
    }

    /**
     * Get the hunter of the match
     */
    public function hunter()
    {
        return $this->belongsTo(User::class, 'hunter_id');
    }

    /**
     * Check if the match is currently active
     */
    public function isActive()
    {
        if (!$this->started_at) {
            return false;
        }

        return now()->lt($this->started_at->copy()->addHours($this->duration_hours));
    }

    /**
     * Get remaining time in seconds
     */
    public function timeRemaining()
    {
        if (!$this->started_at) {
            return null;
        }

        $endTime = $this->started_at->copy()->addHours($this->duration_hours);
        return $endTime->diffInSeconds(now(), false); // negative if expired
    }

    /**
     * Get the pending requests 
     */
    public function pendingRequests()
    {
        return $this->hasMany(PendingRequest::class, 'match_id');
    }

    /**
     * Get the status of the match
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'match_id');
    }
}