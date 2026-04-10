@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'My online Library')

@section('active_home','active')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('body')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="row">
    <div class="col-lg-9 col-sm-12">
        <!-- Mappa OpenStreetMap -->
        <div id="map" style="height: 400px; border: 1px solid #ccc; border-radius: 8px;"></div>

        <script>
            // Inizializza la mappa con una vista di default
            var map = L.map('map').setView([41.9028, 12.4964], 5);

            // Aggiunge il layer di OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Marker statico per la biblioteca
            L.marker([41.9028, 12.4964]).addTo(map)
                .bindPopup('La mia biblioteca virtuale!')
                .openPopup();

            // Trova la posizione dell'utente
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    // Aggiunge un marker per la posizione utente
                    var userMarker = L.marker([userLat, userLng]).addTo(map)
                        .bindPopup("Sei qui!")
                        .openPopup();

                    // Centra la mappa sulla posizione dell'utente
                    map.setView([userLat, userLng], 10);
                }, function(error) {
                    console.error("Geolocalizzazione fallita:", error.message);
                });
            } else {
                alert("Geolocalizzazione non supportata dal browser.");
            }
        </script>
    </div>

    <div class="col-lg-3 col-sm-12">
        <div class="imgBiblio">
            <img class="img-thumbnail img-responsive" src="{{ url('/') }}/img/pretty-4-th.jpg">
        </div>
    </div>
</div>
@endsection