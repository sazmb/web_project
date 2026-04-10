@extends('layouts.master')

@section('title', "HotelExplorer :: {{ $hotel->name ?? 'Hotel details' }}")

@section('active_Hotels','active')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('hotel.index') }}">Hotels</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $hotel->name ?? 'Hotel details' }}</li>
@endsection

@section('body')

<div class="container mt-4">
    <h2>{{ $hotel->name ?? 'Hotel name not available' }}</h2>
    <p><strong>Location:</strong> {{ $hotel->location ?? 'Location not available' }}</p>
    <p><strong>Description:</strong> {{ $hotel->description ?? 'No description available.' }}</p>

    <hr>

    <h4>Reviews ({{ $reviews->count() }})</h4>

    @if($reviews->isEmpty())
        <p>No reviews yet for this hotel.</p>
    @else
        <ul class="list-group mb-4">
            @foreach($reviews as $review)
                <li class="list-group-item">
                    <strong>{{ $review->user->name ?? 'Unknown user' }}</strong> 
                    <span class="text-muted">({{ $review->data ? \Carbon\Carbon::parse($review->data)->format('d/m/Y') : '' }})</span>
                    <br>
                    <strong>Score:</strong> {{ $review->punteggio }}/5<br>
                    <em>{{ $review->commento }}</em>
                </li>
            @endforeach
        </ul>
    @endif

    @auth
        @if(auth()->user()->role === 'registered_user')
        <div id="reviewFormContainer">
            <h5>Add Your Review</h5>
            <form id="reviewForm">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                <div class="mb-3">
                    <label for="punteggio" class="form-label">Score (1-5):</label>
                    <select name="punteggio" id="punteggio" class="form-select" required>
                        <option value="" selected disabled>Select score</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="commento" class="form-label">Comment:</label>
                    <textarea name="commento" id="commento" rows="3" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>

        <div id="message" class="mt-3"></div>
        @endif
    @endauth
</div>

<script>
$(document).ready(function() {
    @auth
        @if(auth()->user()->role === 'registeredUser')
        $.ajax({
            url: "{{ route('ajaxCheckReview') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                hotel_id: "{{ $hotel->id }}"
            },
            success: function(response) {
                if(response.alreadyReviewed) {
                    $("#reviewFormContainer").hide();
                    $("#message").html('<div class="alert alert-warning">You have already submitted a review for this hotel. Multiple reviews are not allowed.</div>');
                }
            },
            error: function() {
                console.error('Error checking review status.');
            }
        });

        $("#reviewForm").submit(function(e) {
            e.preventDefault();
            $("#message").html('');

            $.ajax({
                url: "{{ route('review.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    $("#message").html('<div class="alert alert-success">Review submitted successfully!</div>');
                    $("#reviewForm")[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let errorMessages = '';
                    if(errors) {
                        Object.values(errors).forEach(arr => {
                            arr.forEach(msg => errorMessages += `<p>${msg}</p>`);
                        });
                    } else {
                        errorMessages = 'An error occurred while submitting the review.';
                    }
                    $("#message").html('<div class="alert alert-danger">'+errorMessages+'</div>');
                }
            });
        });
        @endif
    @endauth
});
</script>

@endsection
