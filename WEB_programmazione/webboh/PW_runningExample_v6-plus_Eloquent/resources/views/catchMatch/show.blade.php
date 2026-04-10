<!-- resources/views/matches/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $match->name }}</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Match Details</h5>
                    <p class="card-text">{{ $match->description }}</p>
                    <p>Host: {{ $match->host->name }}</p>
                    <p>Players: {{ $match->approvedPlayers->count() }}/{{ $match->max_players }}</p>
                    
                    @if(!$match->players->contains(Auth::id()))
                        @if($match->hasAvailableSlots())
                            <form method="POST" action="{{ route('matches.join', $match) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Join Match</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Match Full</button>
                        @endif
                    @endif
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Players</h5>
                    <ul class="list-group">
                        @foreach($match->approvedPlayers as $player)
                            <li class="list-group-item">
                                {{ $player->name }}
                                @if($player->id === $match->host_id)
                                    <span class="badge bg-primary">Host</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            @if(Auth::id() === $match->host_id && $match->pendingPlayers->count() > 0)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Pending Join Requests</h5>
                        <ul class="list-group">
                            @foreach($match->pendingPlayers as $player)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $player->name }}
                                    <div>
                                        <form method="POST" action="{{ route('matches.manage-request', [$match, $player]) }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('matches.manage-request', [$match, $player]) }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection