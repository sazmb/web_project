@extends('layouts.mistero')

@section('title', 'Navigazione Voti')

@section('body')
<style>
  .hidden {
    display: none !important;
  }
</style>
<h2 class="text-center mt-4">Navigazione Esami</h2>

<div class="container mt-4 text-center">
    <div class="d-flex justify-content-center align-items-center">
        <!-- Bottone precedente -->
        <button id="prevBtn" class="btn btn-outline-secondary me-2">&lt;</button>

        <!-- Tabella con campi -->
        <table class="table table-bordered align-middle mb-0" style="width: auto;">
            <thead class="table-light">
                <tr>
                    <th>Data appello</th>
                    <th>Matricola</th>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Voto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="date" id="td-data" class="form-control" readonly></td>
                    <td><input type="text" id="td-student_id" class="form-control" readonly></td>
                    <td><input type="text" id="td-last_name" class="form-control" readonly></td>
                    <td><input type="text" id="td-first_name" class="form-control" readonly></td>
                    <td><input type="number" id="td-voto" class="form-control" readonly></td>
                </tr>
            </tbody>
        </table>

        <!-- Bottone successivo -->
        <button id="nextBtn" class="btn btn-outline-secondary ms-2">&gt;</button>
    </div>

    <!-- Pulsanti sotto -->
    <div class="mt-3">
        <button id="editBtn" class="btn btn-primary">Modifica</button>
         <button id="deleteBtn" class="btn btn-danger ms-2">Elimina</button>

      <div id="editControls" class="d-inline-block hidden">
            <button id="cancelEditBtn" class="btn btn-secondary me-2">Annulla</button>
            <button id="confirmEditBtn" class="btn btn-success">Conferma</button>
        </div>
    </div>
</div>

<script>

function inizializzaModalitaVisualizzazione() {
    setReadOnlyMode(true); // Tutti i campi disabilitati
    $('#editControls').addClass('hidden');
    $('#editBtn').show(); // Mostra solo il bottone Modifica
    $('#deleteBtn').show(); // Mostra il bottone Elimina
    $('#prevBtn, #nextBtn').prop('disabled', false); // Abilita la navigazione
}


function validaCampi() {
    let error = false;
    let firstErrorField = null;

    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Estrai e normalizza dati
    let nome = $('#td-first_name').val().trim();
    let cognome = $('#td-last_name').val().trim();
    let matricola = $('#td-student_id').val().trim();
    let voto = $('#td-voto').val().trim();
    let dataEsame = $('#td-data').val().trim();

    const regexNomeCognome = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/;

    // Validazione Nome
    if (nome === '' || !regexNomeCognome.test(nome)) {
        error = true;
        $('#td-first_name').addClass('is-invalid')
            .after(`<div class="invalid-feedback">` +
                (nome === '' ? 'Il nome è obbligatorio' : 'Il nome non può contenere numeri o simboli') +
                `</div>`);
        firstErrorField = firstErrorField || $('#td-first_name');
    }

    // Validazione Cognome
    if (cognome === '' || !regexNomeCognome.test(cognome)) {
        error = true;
        $('#td-last_name').addClass('is-invalid')
            .after(`<div class="invalid-feedback">` +
                (cognome === '' ? 'Il cognome è obbligatorio' : 'Il cognome non può contenere numeri o simboli') +
                `</div>`);
        firstErrorField = firstErrorField || $('#td-last_name');
    }

    // Validazione Matricola
    if (matricola === '' || !/^[1-9]\d*$/.test(matricola)) {
        error = true;
        $('#td-student_id').addClass('is-invalid')
            .after(`<div class="invalid-feedback">` +
                (matricola === '' ? 'La matricola è obbligatoria' : 'La matricola deve essere un numero positivo') +
                `</div>`);
        firstErrorField = firstErrorField || $('#td-student_id');
    }

    // Validazione Voto
    if (voto === '') {
        error = true;
        $('#td-voto').addClass('is-invalid')
            .after(`<div class="invalid-feedback">Il voto è obbligatorio</div>`);
        firstErrorField = firstErrorField || $('#td-voto');
    } else {
        let votoNum = parseInt(voto, 10);
        if (votoNum < 0 || votoNum > 30) {
            error = true;
            $('#td-voto').addClass('is-invalid')
                .after(`<div class="invalid-feedback">Il voto deve essere tra 0 e 30</div>`);
            firstErrorField = firstErrorField || $('#td-voto');
        }
    }

    // Validazione Data
    if (dataEsame === '') {
        error = true;
        $('#td-data').addClass('is-invalid')
            .after(`<div class="invalid-feedback">La data è obbligatoria</div>`);
        firstErrorField = firstErrorField || $('#td-data');
    } else {
        let dataMin = new Date('2020-01-01');
        let dataMax = new Date();
        let dataIns = new Date(dataEsame);
        if (dataIns < dataMin || dataIns > dataMax) {
            error = true;
            $('#td-data').addClass('is-invalid')
                .after(`<div class="invalid-feedback">La data deve essere tra il 01/01/2020 e oggi</div>`);
            firstErrorField = firstErrorField || $('#td-data');
        }
    }

    if (error) {
        if (firstErrorField) firstErrorField.focus();
        return false;
    }

    return true;
}


//gestione di navigazione tra i record
let currentIndex = 0;
let recordIds = [];
let datiOriginali = {}; // Per ripristinare in caso di annulla

function caricaRecord(id) {
    $.ajax({
        url: '/student/' + id,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#td-data').val(data.data);
            $('#td-student_id').val(data.student_id);
            $('#td-last_name').val(data.last_name);
            $('#td-first_name').val(data.first_name);
            $('#td-voto').val(data.voto);

            // Salvo dati originali per annulla
            datiOriginali = { ...data };
        },
        error: function() {
            alert("Errore nel caricamento del record");
        }
    });
}

function aggiornaFrecce() {
    $('#prevBtn').prop('disabled', currentIndex <= 0);
    $('#nextBtn').prop('disabled', currentIndex >= recordIds.length - 1);
}

function setReadOnlyMode(enabled) {
    const readonly = enabled ? true : false;
    $('#td-data, #td-student_id, #td-last_name, #td-first_name, #td-voto').prop('readonly', readonly);
}

$(document).ready(function() {

    inizializzaModalitaVisualizzazione(); // Inizializza la modalità visualizzazione
    

    // Elimina record
    $('#deleteBtn').click(function () {
        if (!confirm("Sei sicuro di voler eliminare questo record?")) return;

        const idToDelete = recordIds[currentIndex];

        $.ajax({
            url: '/student/delete/' + idToDelete,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function (response) {
                alert('Record eliminato con successo.');

                // Rimuovi ID dalla lista
                recordIds.splice(currentIndex, 1);

                // Se non ci sono più record
                if (recordIds.length === 0) {
                    $('#td-data, #td-student_id, #td-last_name, #td-first_name, #td-voto').val('');
                    $('#prevBtn, #nextBtn, #editBtn').prop('disabled', true);
                    $('#deleteBtn').hide();
                    return;
                }

                // Altrimenti carica il record successivo o precedente
                if (currentIndex >= recordIds.length) {
                    currentIndex = recordIds.length - 1; // Vai indietro se era l'ultimo
                }

                caricaRecord(recordIds[currentIndex]);
                aggiornaFrecce();

                // Torna a visualizzazione
                inizializzaModalitaVisualizzazione();
            },
            error: function () {
                alert('Errore durante l\'eliminazione.');
            }
        });
    });
    // Carica lista ID
    $.ajax({
        url: '{{ route('student.listaId') }}',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            recordIds = data.ids;
            if (recordIds.length > 0) {
                caricaRecord(recordIds[0]);
                aggiornaFrecce();
            }
        }
    });

    $('#prevBtn').click(function() {
        if (currentIndex > 0) {
            currentIndex--;
            caricaRecord(recordIds[currentIndex]);
            aggiornaFrecce();
        }
    });

    $('#nextBtn').click(function() {
        if (currentIndex < recordIds.length - 1) {
            currentIndex++;
            caricaRecord(recordIds[currentIndex]);
            aggiornaFrecce();
        }
    });

    // Entra in modalità modifica
    $('#editBtn').click(function() {
        setReadOnlyMode(false); // Attiva input editabili
        $('#prevBtn, #nextBtn').prop('disabled', true); // Blocca navigazione
        $('#editBtn').hide(); // Nasconde bottone Modifica
        $('#deleteBtn').hide(); // Nasconde bottone Elimina
        $('#editControls').removeClass('hidden');
    });

    // Annulla modifica
    $('#cancelEditBtn').click(function() {
        // Ripristina valori
        $('#td-data').val(datiOriginali.data);
        $('#td-student_id').val(datiOriginali.student_id);
        $('#td-last_name').val(datiOriginali.last_name);
        $('#td-first_name').val(datiOriginali.first_name);
        $('#td-voto').val(datiOriginali.voto);

        // Torna a modalità visualizzazione
        setReadOnlyMode(true);
        $('#prevBtn, #nextBtn').prop('disabled', false);
        $('#editBtn').show();
        $('#deleteBtn').show(); // Mostra il bottone Elimina
        $('#editControls').addClass('hidden');
    });

    // Conferma modifica
    $('#confirmEditBtn').click(function() {
      if (!validaCampi()) return;

     if (!confirm("Confermare la modifica di questo record?")) return;

        // Recupera dati dal form
        let updatedData = {
            id: recordIds[currentIndex],
            data: $('#td-data').val(),
            student_id: $('#td-student_id').val(),
            last_name: $('#td-last_name').val(),
            first_name: $('#td-first_name').val(),
            voto: $('#td-voto').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '/student/' + updatedData.id + '/update',
            method: 'POST',
            data: updatedData,
            success: function(response) {
                alert('Modifica salvata con successo!');
                setReadOnlyMode(true);
                $('#prevBtn, #nextBtn').prop('disabled', false);
                $('#editBtn').show();
                 $('#editControls').addClass('hidden');
                datiOriginali = { ...updatedData };
            },
            error: function() {
                alert('Errore durante il salvataggio.');
            }
        });
    });
});
</script>



@endsection
