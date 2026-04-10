@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', __('messages.title'))

@section('active_home','active')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-9 col-sm-12">
        <div class="citazione">
            @if (auth()->check())
                <h1>{{ __('messages.welcome') }}, {{ auth()->user()->name }}!</h1>
                <a class="btn btn-primary" href="{{ route('book.index') }}">Accedi alla tua libreria</a>
            @else
                <blockquote>
                    <text> Loggati per accedere al contenuto delle lezioni</text>
                </blockquote>
            @endif
        </div>
    </div>


@endsection