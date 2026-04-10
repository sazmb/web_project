@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Book details')

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('book.index') }}">Library</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('book.index') }}">Books</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
@endsection

@section('body')
<div class="row">
    <div class="col-md-10">
        <div class="row mb-3">
            <div class="col-md-3">
                <b>Commento:</b>
            </div>
            <div class="col-md-9">
                {{ $review->commento }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <b>Voto:</b>
            </div>
            <div class="col-md-9">
                {{ $review->voto }}
            </div>
        </div>

        
    </div>

    


                                <a class="btn btn-secondary" href="{{ route('review.indexHotel', ['hotel' => $review->hotel_id]) }}">
                                    Reviews
                                </a>
                            
</div>
@endsection