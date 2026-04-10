@extends('layouts.master')

@section('title', 'Biblios :: Books\' List')
@section('active_MyLibrary','active')

{{-- Breadcrumb di navigazione --}}
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active">Library</li>
<li class="breadcrumb-item active">Trans</li>
@endsection

@section('body')
<script>
$(document).ready(function() {

    // ============================
    // 1. Funzione per calcolare e aggiornare il saldo totale
    // ============================
    function aggiornaSaldo() {
        $.ajax({
            url: "{{ route('ajax.calcolaSomma') }}", // Chiamata AJAX al backend
            method: "GET",
            success: function(response) {
                let saldo = parseFloat(response.somma); // Parsing della somma
                let colore = saldo > 0 ? 'text-success' : (saldo < 0 ? 'text-danger' : 'text-dark');
                // Mostra il saldo formattato e con colore appropriato
                $("#saldoBox").html(
                    `<strong>Saldo:</strong> <span class="${colore}">${saldo.toFixed(2)} €</span>`
                    );
            },
            error: function() {
                // In caso di errore, messaggio visibile all'utente
                $("#saldoBox").html(
                '<span class="text-danger">Errore nel calcolo del saldo</span>');
            }
        });
    }

    aggiornaSaldo(); // Calcolo saldo al caricamento

    // ============================
    // 2. Toggle per cambiare tipo della transazione (entrata <-> spesa)
    // ============================
    $(document).on('change', '.toggleTipo', function() {
        let checkbox = $(this);
        let id = checkbox.data('id'); // ID della transazione

        $.ajax({
            url: "{{ route('trans.toggleTipo') }}", // Backend: cambia tipo
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}", // CSRF token per sicurezza
                id: id
            },
            success: function(response) {
                let row = $('#trans-' + id); // Trova la riga HTML
                let tipoCell = row.find('td.tipo');
                let importoCell = row.find('td').eq(1); // Seconda colonna = importo

                // Aggiorna testo e colore della colonna "Tipo"
                tipoCell.text(response.tipo.charAt(0).toUpperCase() + response.tipo.slice(
                    1));
                tipoCell.removeClass('text-success text-danger')
                    .addClass(response.tipo === 'entrata' ? 'text-success' : 'text-danger');

                // Aggiorna colore della colonna "Importo"
                importoCell.removeClass('text-success text-danger')
                    .addClass(response.tipo === 'entrata' ? 'text-success' : 'text-danger');

                // Applica o rimuove opacità per tipo "spesa"
                row.toggleClass('opacity-50', response.tipo === 'spesa');

                aggiornaSaldo(); // Ricalcola il saldo dopo la modifica
            }
        });
    });

    // ============================
    // 3. Eliminazione transazione con conferma via AJAX
    // ============================
    $(document).on('click', '.deleteTrans', function() {
        if (!confirm("Sei sicuro di voler eliminare questa transazione?")) return;

        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('trans.destroyAjax') }}",
            method: "POST", // Metodo POST con override
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE", // Override del metodo DELETE
                id: id
            },
            success: function(response) {
                console.log('Risposta ricevuta dal server:', response);
                $('#trans-' + id).remove(); // Rimuove riga dal DOM
                aggiornaSaldo(); // Ricalcola il saldo
                // Mostra modale di conferma
                $('#deleteModalBody').text('La transazione ID #' + id +
                    ' è stata eliminata.');
                $('#deleteConfirmModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Errore nella chiamata AJAX:', error);
            }
        });
    });

    // ============================
    // 4. Ricerca per colonna selezionata
    // ============================
    $(".searchOptions").on("click", function(e) {
        e.preventDefault(); // Previene il comportamento di default del link
        var column = $(this).attr("data-column");
        $("#searchInput").attr("data-column", column); // Imposta colonna per filtro
        $("#searchInput").attr("placeholder", "Search " + $(this).text().toLowerCase() + "...");
        $("#searchInput").trigger("keyup"); // Attiva la ricerca attuale
    });

    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase(); // Testo inserito
        var column = $("#searchInput").attr("data-column");

        $("#paginationNav").toggle(value === ""); // Mostra/nasconde paginazione

        // Cicla tutte le righe della tabella
        $("#transTable tbody tr").each(function() {
            var found = false;
            if ((column == -1) || (column === undefined)) {
                // Ricerca su tutte le celle (escluse ultime colonne azione)
                $(this).find("td").slice(0, -3).each(function() {
                    if ($(this).text().toLowerCase().indexOf(value) > -1) found = true;
                });
            } else {
                // Ricerca in colonna specifica
                var $td = $(this).find("td:eq(" + column + ")");
                if ($td.length && $td.text().toLowerCase().indexOf(value) > -1) found = true;
            }
            $(this).toggle(found); // Mostra solo righe corrispondenti
        });
    });
});
</script>

{{-- ===============================
     STRUTTURA HTML DELLA VISTA
   =============================== --}}
<div class="container-fluid">

    {{-- 🔍 Barra di ricerca con selezione colonna --}}
    <div class="row">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Search by</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item searchOptions" href="#" data-column="0">Title</a></li>
                    <li><a class="dropdown-item searchOptions" href="#" data-column="1">Author</a></li>
                    <li><a class="dropdown-item searchOptions" href="#" data-column="-1">Title or author</a></li>
                </ul>
            </div>
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div>
    </div>

    {{-- 📄 Navigazione (paginazione visuale) --}}
    <nav id="paginationNav" class="mb-3">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
            <li>
                <select id="rowsPerPage" class="form-control">
                    <option value="5">5 trans per page</option>
                    <option value="10">10 trans per page</option>
                    <option value="15">15 trans per page</option>
                    <option value="20">20 trans per page</option>
                </select>
            </li>
        </ul>
    </nav>

    {{-- 💰 Box saldo e pulsante "Nuova transazione" --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div id="saldoBox" class="alert alert-light border shadow-sm">
                <strong>Saldo:</strong> <em>Caricamento...</em>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-success" href="{{ route('trans.create') }}">
                <i class="bi bi-database-add"></i> Create new trans
            </a>
        </div>
    </div>

    {{-- 📊 Tabella delle transazioni --}}
    <div class="row">
        <div class="col-md-12">
            <table id="transTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Importo</th>
                        <th>Descrizione</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Check</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Generazione dinamica delle righe --}}
                    @foreach ($trans_list as $trans)
                    @php
                    $isSpesa = $trans->tipo === 'spesa';
                    @endphp
                    <tr id="trans-{{ $trans->id }}" class="{{ $isSpesa ? 'opacity-50' : '' }}">
                        <td>{{ $trans->id }}</td>
                        <td class="{{ $isSpesa ? 'text-danger' : 'text-success' }}">
                            {{ number_format($trans->importo, 2) }} €</td>
                        <td>{{ $trans->descrizione }}</td>
                        <td>{{ $trans->data }}</td>
                        <td class="tipo {{ $isSpesa ? 'text-danger' : 'text-success' }}">{{ ucfirst($trans->tipo) }}
                        </td>
                        <td>
                            {{-- Checkbox per cambiare tipo --}}
                            <input type="checkbox" class="form-check-input toggleTipo" data-id="{{ $trans->id }}"
                                {{ $isSpesa ? 'checked' : '' }}>
                        </td>
                        <td>
                            {{-- Pulsante per eliminare la transazione --}}
                            <button class="btn btn-danger btn-sm deleteTrans" data-id="{{ $trans->id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Modale Bootstrap per conferma eliminazione --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="deleteConfirmLabel">Transazione Eliminata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body" id="deleteModalBody">
                    La transazione è stata eliminata con successo.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection