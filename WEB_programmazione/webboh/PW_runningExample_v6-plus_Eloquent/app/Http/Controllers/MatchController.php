<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/MatchController.php
namespace App\Http\Controllers;

use App\Models\CatchMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $matches = CatchMatch::withCount(['approvedPlayers as player_count'])
            ->get()
            ->filter(function($match) {
                return $match->player_count < $match->max_players;
            });
            
        return view('matches.index', compact('matches'));
    }
    
    public function show(CatchMatch $match)
    {
        $match->load('host', 'approvedPlayers', 'pendingPlayers');
        return view('matches.show', compact('match'));
    }
    
    public function join(Request $request, CatchMatch $match)
    {
        // Check if user is already in the match
        if ($match->players()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You are already in this match.');
        }
        
        // Check if match has available slots
        if (!$match->hasAvailableSlots()) {
            return back()->with('error', 'This match is already full.');
        }
        
        // Add user to match with pending status
        $match->players()->attach(Auth::id(), ['status' => 'pending']);
        
        return back()->with('success', 'Join request sent to the host.');
    }
    
    public function manageJoinRequest(Request $request, CatchMatch $match, $userId)
    {
        // Verify the current user is the host
        if ($match->host_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $action = $request->input('action');
        
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Invalid action.');
        }
        
        // Update the status
        $match->players()->updateExistingPivot($userId, [
            'status' => $action === 'approve' ? 'approved' : 'rejected'
        ]);
        
        return back()->with('success', 'Request '.$action.'d.');
    }
}
