@extends('layouts.mistero')

@section('title', 'Navigazione Voti')

@section('body')

<h2 class="text-center mt-4">Navigazione Esami</h2>

<div class="container mt-4 text-center">
    <div class="d-flex justify-content-center align-items-center">
        <!-- Bottone precedente -->
        <button id="prevBtn" class="btn btn-outline-secondary me-2">&lt;</button>

        <!-- Tabella con intestazione e campi disabilitati -->
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
                    <td><input type="text" id="td-data" class="form-control" readonly></td>
                    <td><input type="text" id="td-student_id" class="form-control" readonly></td>
                    <td><input type="text" id="td-last_name" class="form-control" readonly></td>
                    <td><input type="text" id="td-first_name" class="form-control" readonly></td>
                    <td><input type="text" id="td-voto" class="form-control" readonly></td>
                     <!--   <td>
                            <select id="voto" class="form-select" disabled>
                                <option value="">Scegliere un'opzione</option>
                                @for ($i = 0; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i == 31 ? '30 e lode' : $i }}</option>
                                @endfor
                            </select>
                        </td>-->
                </tr>
            </tbody>
        </table>
        <!-- Tabella con ID e campi disabilitati -->

        <!-- Bottone successivo -->
        <button id="nextBtn" class="btn btn-outline-secondary ms-2">&gt;</button>
    </div>

    <!-- Bottone salva -->
    <div class="mt-3">
        <button id="saveBtn" class="btn btn-secondary" disabled>Salva</button>
    </div>

</div>


<script>
// Variabili globali
let currentIndex = 0; // Indice corrente dell'elemento mostrato
let totalRecords = 0; // Numero totale di record
let recordIds = []; // Array di ID dei record da navigare

// Funzione che carica i dati di un record specifico, dato il suo ID
function caricaRecord(id) {
    $.ajax({
        url: '/student/' + id, // Chiede al server i dati del record con ID specificato
        method: 'GET',
        dataType: 'json',

        success: function(data) {
            // Riempie i campi del form con i dati restituiti dal server
            console.log(" Dati ricevuti dal server:", data);
            $('#td-data').val(data.data);
            $('#td-student_id').val(data.student_id);
            $('#td-last_name').val(data.last_name);
            $('#td-first_name').val(data.first_name);
            $('#td-voto').val(data.voto);
        },
        error: function() {
            alert("Errore nel caricamento del record");
        }
    });
}

// Abilita/disabilita le freccette in base alla posizione corrente
function aggiornaFrecce() {
    $('#prevBtn').prop('disabled', currentIndex <= 0); // Disabilita "<" se sei al primo record
    $('#nextBtn').prop('disabled', currentIndex >= recordIds.length - 1); // Disabilita ">" se sei all’ultimo
}

// Quando il documento è pronto:
$(document).ready(function() {
    // Prima richiesta: recupera la lista degli ID disponibili
    $.ajax({
        url: '{{ route('student.listaId') }}',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("Dati ricevuti dal server:", data);
            recordIds = data.ids; // Salva gli ID dei record
            totalRecords = recordIds.length; // Conta quanti sono
            if (totalRecords > 0) {
                currentIndex = 0; // Inizia dal primo
                caricaRecord(recordIds[currentIndex]); // Carica il primo record
                aggiornaFrecce(); // Aggiorna lo stato dei pulsanti
            }
        }
    });

    // Quando si clicca su "<"
    $('#prevBtn').click(function() {
        if (currentIndex > 0) {
            currentIndex--; // Vai al record precedente
            caricaRecord(recordIds[currentIndex]); // Caricalo
            aggiornaFrecce(); // Aggiorna frecce
        }
    });

    // Quando si clicca su ">"
    $('#nextBtn').click(function() {
        if (currentIndex < recordIds.length - 1) {
            currentIndex++; // Vai al record successivo
            caricaRecord(recordIds[currentIndex]); // Caricalo
            aggiornaFrecce(); // Aggiorna frecce
        }
    });
});
</script>

@endsection