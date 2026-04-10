@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Prova a prendermi')

@section('active_home','active')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-9 col-sm-12">
        <h5 class="mb-3">Library Location</h5>
        <div id="map" style="height: 400px; width: 100%; border: 1px solid #ccc;"></div>
    </div>

    <div class="col-lg-3 col-sm-12">
        <div class="imgBiblio">
            <img class="img-thumbnail img-responsive" src="{{ url('/') }}/img/pretty-4-th.jpg">
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-sA+4qNDGSmWZ7kTbtU3RYv7vzzTqHSA0G5xwKp6NH2I=" crossorigin=""/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
   integrity="sha256-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44c=" crossorigin=""></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([45.4642, 9.1900], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([45.4642, 9.1900]).addTo(map)
            .bindPopup('Prova a prendermi')
            .openPopup();
    });
</script>
@endsection