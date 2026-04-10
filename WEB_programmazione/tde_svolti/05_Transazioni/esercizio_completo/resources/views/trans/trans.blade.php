@extends('layouts.master')
<!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Books\' List')

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Library</li>
<li class="breadcrumb-item active" aria-current="page">Trans</li>
@endsection

@section('body')
<script>
$(document).ready(function() {
    $.ajax({
        url: "{{ route('ajax.calcolaSomma') }}",
        method: "GET",
        success: function(response) {
            let saldo = parseFloat(response.somma);
            let colore = 'text-dark';
            if (saldo > 0) colore = 'text-success';
            else if (saldo < 0) colore = 'text-danger';

            $("#saldoBox").html(
                `<strong>Saldo:</strong> <span class="${colore}">${saldo.toFixed(2)} €</span>`
            );
        },
        error: function() {
            $("#saldoBox").html('<span class="text-danger">Errore nel calcolo del saldo</span>');
        }
    });
    // Searching feature
    $(".searchOptions").on("click", function(e) {
        e.preventDefault();
        var column = $(this).attr("data-column");
        $("#searchInput").attr("data-column", column);
        $("#searchInput").attr("placeholder", "Search " + $(this).text().toLowerCase() + "...");
        $("#searchInput").trigger("keyup"); // Riesegui la ricerca quando viene selezionata una colonna
    });

    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        // Reimposta completamente la paginazione se il campo di ricerca viene svuotato
        if (value !== "") {
            $("#paginationNav").hide();
        } else {
            $("#paginationNav").show();
            currentPage = 1; // Riporta alla prima pagina
            return;
        }

        var column = $("#searchInput").attr("data-column");

        $("#TransTable tbody tr").each(function() {
            var found = false;
            if ((column == -1) || (column ===
                undefined)) { // Selezionato "Title or author" o nessuna opzione
                $(this).find("td").slice(0, -3).each(
            function() { // Escludi le ultime tre colonne
                    var text = $(this).text().toLowerCase();
                    if (text.indexOf(value) > -1) {
                        found = true;
                    }
                });
            } else {
                var $td = $(this).find("td:eq(" + column + ")");
                if ($td.length > 0) {
                    var text = $td.text().toLowerCase();
                    if (text.indexOf(value) > -1) {
                        found = true;
                    }
                }
            }
            $(this).toggle(found);
        });
    });
});
</script>

<div class="container-fluid">
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
            <input type="text" id="searchInput" class="form-control" aria-label="Text input with dropdown button"
                placeholder="Search...">
        </div>
    </div>

    <nav aria-label="Page navigation example" id="paginationNav">
        <ul class="pagination justify-content-center">
            <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
            <!-- Numeri di pagina -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
            <li>
                <select id="rowsPerPage" class="form-control justify-content-end">
                    <option value="5">5 trans per page</option>
                    <option value="10">10 trans per page</option>
                    <option value="15">15 trans per page</option>
                    <option value="20">20 trans per page</option>
                </select>
            </li>
        </ul>
    </nav>

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
</div>
<div class="row">
    <div class="col-md-12">
        <table id="transTable" class="table table-striped table-hover">
            <col width='40%'>
            <col width='30%'>
            <col width='10%'>
            <col width='10%'>
            <col width='10%'>
            <thead>
                <tr>
                    <th>id</th>
                    <th>importo</th>
                    <th>descrizione</th>
                    <th>data</th>
                    <th>tipo</th>
                </tr>
            </thead>
<tbody>
    @foreach ($trans_list as $trans)
        @php
            $coloreImporto = $trans->tipo === 'entrata' ? 'text-success' : 'text-danger';
            $coloreTipo = $trans->tipo === 'entrata' ? 'text-success' : 'text-danger';
        @endphp
        <tr>
            <td>{{ $trans->id }}</td>
            <td class="{{ $coloreImporto }}">{{ number_format($trans->importo, 2, '.', '') }} €</td>
            <td>{{ $trans->descrizione }}</td>
            <td>{{ $trans->data }}</td>
            <td class="{{ $coloreTipo }}">{{ ucfirst($trans->tipo) }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('trans.edit',['trans' => $trans->id]) }}">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            </td>
            <td>
                <a class="btn btn-danger" href="{{ route('trans.destroy.confirm',['id' => $trans->id]) }}">
                    <i class="bi bi-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>
</div>
@endsection