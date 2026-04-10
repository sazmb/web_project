<!-- resources/views/matches/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Matches</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <div class="row">
        @foreach($matches as $match)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $match->name }}</h5>
                        <p class="card-text">{{ $match->description }}</p>
                        <p>Host: {{ $match->host->name }}</p>
                        <p>Players: {{ $match->player_count }}/{{ $match->max_players }}</p>
                        <a href="{{ route('matches.show', $match) }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection