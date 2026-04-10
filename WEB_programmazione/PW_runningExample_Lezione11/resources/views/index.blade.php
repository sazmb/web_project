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
            document.addEventListener('DOMContentLoaded', function () {
                const map = L.map('map').setView([41.9028, 12.4964], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Icona personalizzata
                const customIcon = L.icon({
                    iconUrl: '{{ asset("img/prova.png") }}',
                    iconSize:     [38, 38], // modifica se serve
                    iconAnchor:   [19, 38], // punta dell'icona (al centro sotto)
                    popupAnchor:  [0, -38]  // posizione del popup rispetto all’icona
                });

                // Marker biblioteca (Roma)
                L.marker([41.9028, 12.4964], { icon: customIcon })
                    .addTo(map)
                    .bindPopup('La mia biblioteca virtuale!')
                    .openPopup();

                // Marker fittizio 1 (Milano)
                L.marker([45.4642, 9.19], { icon: customIcon })
                    .addTo(map)
                    .bindPopup('Utente fittizio (Milano)');

                // Marker fittizio 2 (Napoli)
                L.marker([40.8518, 14.2681], { icon: customIcon })
                    .addTo(map)
                    .bindPopup('Utente fittizio (Napoli)');

                // Marker utente reale
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        L.marker([lat, lng], { icon: customIcon })
                            .addTo(map)
                            .bindPopup("Sei qui!")
                            .openPopup();

                        map.setView([lat, lng], 10);
                    }, function (err) {
                        alert("Errore geolocalizzazione: " + err.message);
                    });
                } else {
                    alert("Geolocalizzazione non supportata dal browser.");
                }
            });
        </script>
    </div>

    <div class="col-lg-3 col-sm-12">
        <div class="imgBiblio">
            <img class="img-thumbnail img-responsive" src="{{ url('/') }}/img/pretty-4-th.jpg">
        </div>
    </div>
</div>

@endsection