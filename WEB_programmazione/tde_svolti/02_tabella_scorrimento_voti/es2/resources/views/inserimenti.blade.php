@extends('layouts.mistero')

@section('title', 'Voti Studente PW')

@section('active_MyLibrary','active')

@section('body')
<!--<script>
  $(document).ready(function() {
    $('#avgModal').on('show.bs.modal', function() {
      var modalBody = $('#modalBody');
      modalBody.html('Caricamento...');
      $.ajax({
        url: 'voti.salva',
        method: 'GET',
        success: 
        /*function(data) {
          if (data.success && Array.isArray(data.squadre)) {
            let html = '<h5>Medie simulate per ogni squadra:</h5><ul class="list-group">';
            data.squadre.forEach(function(s) {
              html += `
                <li class="list-group-item">
                  <strong>${s.name}</strong><br>
                  Partite giocate: ${s.partite_giocate}<br>
                  Media gol fatti: <span class="text-success">${s.media_gol_fatti}</span><br>
                  Media gol subiti: <span class="text-danger">${s.media_gol_subiti}</span>
                </li>
              `;
            });
            html += '</ul>';
            modalBody.html(html);
          } else {
            modalBody.html('<p class="text-danger">Nessuna squadra disponibile.</p>');
          }
        },*/
         function (){modalBody.html('<p class="text-danger">Errore nel caricamento dei dati delle squadre.</p>')},
        error: function() {
          modalBody.html('<p class="text-danger">Errore nel caricamento dei dati delle squadre.</p>');
        }
      });
    });
  });
</script>--->
@if(session('message'))
<script>
    $(document).ready(function () {
        $('#modalBody').text(@json(session('message')));
        $('#avgModal').modal('show');
    });
</script>
@endif
<h1>Inserimento Voto Studente</h1>

<form method="POST" action="{{ route('voti.salva') }}" id="formVoti" name="formVoti">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" required>
        <div class="invalid-feedback" id="invalid-nome"></div>
    </div>
    <div class="mb-3">
        <label for="cognome" class="form-label">Cognome</label>
        <input type="text" name="cognome" id="cognome" class="form-control" required>
        <div class="invalid-feedback" id="invalid-cognome"></div>
    </div>
    <div class="mb-3">
        <label for="matricola" class="form-label">Matricola</label>
        <input type="text" name="matricola" id="matricola" class="form-control" required>
        <div class="invalid-feedback" id="invalid-matricola"></div>
    </div>
    <div class="mb-3">
        <label for="voto" class="form-label">Voto</label>
        <input type="number" name="voto" id="voto" class="form-control" required>
        <div class="invalid-feedback" id="invalid-voto"></div>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="lode" id="lode" value="1">
        <label class="form-check-label" for="lode">Lode</label>
    </div>
    <div class="mb-3">
        <label for="data_esame" class="form-label">Data Esame</label>
        <input type="date" name="data_esame" id="data_esame" class="form-control" required>
        <div class="invalid-feedback" id="invalid-data_esame"></div>
    </div>
    <div class="mb-3">
        <label for="commenti" class="form-label">Commenti</label>
        <textarea name="commenti" id="commenti" class="form-control" rows="3"></textarea>
        <div class="invalid-feedback" id="invalid-commenti"></div>
    </div>

    <input type="hidden" name="azione" id="azione" value="invia">

    <button type="submit" class="btn btn-success" onclick="document.getElementById('azione').value='invia'">Invia</button>
    <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler cancellare tutti i dati inseriti?') && (document.getElementById('azione').value='cancella')">Cancella</button>
</form>

<script>
$(document).ready(function(){
    $('#formVoti').submit(function(event){
        event.preventDefault();

        // Pulisci errori precedenti
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        let error = false;
        let firstErrorField = null;

        // Lettura valori
        let nome = $('#nome').val().trim();
        let cognome = $('#cognome').val().trim();
        let matricola = $('#matricola').val().trim();
        let voto = $('#voto').val().trim();
        let lode = $('#lode').is(':checked');
        let dataEsame = $('#data_esame').val().trim();

        // Controlli client-side

        // Nome e cognome non possono contenere numeri e sono obbligatori
        let regexNomeCognome = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/; // accetta lettere, spazi, apostrofi, accenti

        if(nome === ''){
            error = true;
            $('#invalid-nome').text('Il nome è obbligatorio');
            $('#nome').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#nome');
        } else if(!regexNomeCognome.test(nome)){
            error = true;
            $('#invalid-nome').text('Il nome non può contenere numeri o caratteri speciali');
            $('#nome').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#nome');
        }

        if(cognome === ''){
            error = true;
            $('#invalid-cognome').text('Il cognome è obbligatorio');
            $('#cognome').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#cognome');
        } else if(!regexNomeCognome.test(cognome)){
            error = true;
            $('#invalid-cognome').text('Il cognome non può contenere numeri o caratteri speciali');
            $('#cognome').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#cognome');
        }

        // Matricola obbligatoria e intero positivo
        if(matricola === ''){
            error = true;
            $('#invalid-matricola').text('La matricola è obbligatoria');
            $('#matricola').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#matricola');
        } else if(!/^[1-9]\d*$/.test(matricola)){
            error = true;
            $('#invalid-matricola').text('La matricola deve essere un numero intero positivo');
            $('#matricola').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#matricola');
        }

        // Data esame obbligatoria (puoi migliorare con controllo data valida)
        if(dataEsame === ''){
            error = true;
            $('#invalid-data_esame').text('La data dell\'esame è obbligatoria');
            $('#data_esame').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#data_esame');
        }

        // Voto obbligatorio, se lode settato voto deve essere 31, altrimenti deve essere 18-30 o insufficiente (<18)
        if(voto === ''){
            error = true;
            $('#invalid-voto').text('Il voto è obbligatorio');
            $('#voto').addClass('is-invalid');
            firstErrorField = firstErrorField || $('#voto');
        } else {
            let votoNum = parseInt(voto, 10);
            if(lode && votoNum !== 31){
                // Se lode settato il voto in input deve essere ignorato o forzato a 31
                // Puoi decidere come gestire: qui mostriamo errore se non è 31
                // Ma meglio ignorare input e settare 31 lato server o qui
                votoNum = 31;
            } else if(!lode && (votoNum < 0 || votoNum > 30)){
                error = true;
                $('#invalid-voto').text('Il voto deve essere compreso tra 0 e 30 (31 se lode)');
                $('#voto').addClass('is-invalid');
                firstErrorField = firstErrorField || $('#voto');
            }
        }

        if(error){
            firstErrorField.focus();
            return;
        }

        // Se nessun errore client-side facciamo controllo AJAX lato server (esistenza esame superato)

        $.ajax({
            url: '{{ route("voti.verifiche") }}',  // dovrai creare questa rotta e metodo nel controller
            method: 'POST',
            data: {
                nome: nome,
                cognome: cognome,
                matricola: matricola,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.exists) {
                    error = true;
                    $('#invalid-matricola').text('Esiste già un esame superato per questo studente.');
                    $('#matricola').addClass('is-invalid');
                    $('#matricola').focus();
                } else {
                    // Se tutto ok, submit della form normale per salvare i dati
                    $('#formVoti')[0].submit();
                }
            },
            error: function() {
                alert('Errore nella verifica lato server, riprova più tardi.');
            }
        });

    });
});
</script>

<hr>

<h3>Statistiche Voti</h3>
<div id="stats-container">
    <p class="text-muted">Caricamento statistiche...</p>
</div>

<!-- Modale mantenuto invariato -->
<div class="modal fade" id="avgModal" tabindex="-1" aria-labelledby="avgModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avgModalLabel">Invio Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- I dati verranno inseriti qui via JS -->
      </div>
    </div>
  </div>
</div>

<script>
    function caricaStatistiche() {
        $.ajax({
            url: '{{ route('voti.statistiche') }}',
            method: 'GET',
            dataType: 'json', 
            success: function (data) {
                if (data && typeof data === 'object') {
                    let html = `
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Numero voti presenti: <strong>${data.totale}</strong></li>
                            <li class="list-group-item">Voto medio (solo sufficienti): <strong>${data.media}</strong></li>
                            <li class="list-group-item">Percentuale sufficienti: <strong>${data.percentuale_sufficienti}%</strong></li>
                            <li class="list-group-item">Voto massimo: <strong>${data.max}</strong></li>
                            <li class="list-group-item">Voto minimo: <strong>${data.min}</strong></li>
                        </ul>`;
                    $('#stats-container').html(html);
                } else {
                    $('#stats-container').html('<p class="text-danger">Errore nel caricamento delle statistiche.</p>');
                }
            },
            error: function () {
                $('#stats-container').html('<p class="text-danger">Errore nella richiesta AJAX.</p>');
            }
        });
    }

    $(document).ready(function () {
        caricaStatistiche(); // carica le stats al caricamento della pagina
    });
</script>

@endsection