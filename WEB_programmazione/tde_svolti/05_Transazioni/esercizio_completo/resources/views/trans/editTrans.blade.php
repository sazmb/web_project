@extends('layouts.master')

@section('title')
@if(isset($trans))
Biblios :: Edit Trans
@else
Biblios :: Add New Trans
@endif
@endsection

@section('active_MyLibrary', 'active')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('trans.index') }}">Transazioni</a></li>
@if(isset($trans))
<li class="breadcrumb-item active">Modifica Transazione</li>
@else
<li class="breadcrumb-item active">Nuova Transazione</li>
@endif
@endsection

@section('body')

{{-- ✅ SCRIPT VALIDAZIONE FORM TRANS --}}
<script>
$(document).ready(function() {
    $("form[name='trans']").submit(function(event) {
        let error = false;

        // ✅ VALIDAZIONE CAMPO DESCRIZIONE
        let descrizione = $("input[name='descrizione']").val().trim();
        if (descrizione === "") {
            error = true;
            $("#invalid-descrizione").text("La descrizione è obbligatoria.");
            event.preventDefault();
            $("input[name='descrizione']").focus();
        } else {
            $("#invalid-descrizione").text("");
        }

        // ✅ VALIDAZIONE CAMPO IMPORTO
let importo = $("input[name='importo']").val().trim();
if (importo === "") {
    error = true;
    $("#invalid-importo").text("L'importo è obbligatorio.");
    event.preventDefault();
    $("input[name='importo']").focus();
} else {
    // Accetta numeri interi o decimali con punto
    let regexImporto = /^\d+(\.\d{0,})?$/;
    if (!regexImporto.test(importo)) {
        error = true;
        $("#invalid-importo").text("Formato importo non valido. Usa solo numeri e punto per i decimali.");
        event.preventDefault();
        $("input[name='importo']").focus();
    } else {
        // Normalizza l'importo a due cifre decimali
        let parts = importo.split('.');
        let intero = parts[0];
        let decimali = parts[1] || "00";

        if (decimali.length > 2) {
            decimali = Math.round(parseFloat("0." + decimali) * 100).toString().padStart(2, '0');
        } else if (decimali.length < 2) {
            decimali = decimali.padEnd(2, '0');
        }

        let importoNormalizzato = intero + '.' + decimali;
        $("input[name='importo']").val(importoNormalizzato);
        $("#invalid-importo").text("");
    }
}

        // ✅ VALIDAZIONE CAMPO DATA
        let data = $("input[name='data']").val().trim();
        if (data === "") {
            error = true;
            $("#invalid-data").text("La data è obbligatoria.");
            event.preventDefault();
            $("input[name='data']").focus();
        } else {
            $("#invalid-data").text("");
        }

        // ✅ VALIDAZIONE CAMPO TIPO
        if ($("select[name='tipo_transazione']").val() === null) {
            error = true;
            $("#invalid-tipo-transazione").text("Seleziona un tipo.");
            event.preventDefault();
            $("select[name='tipo_transazione']").focus();
        } else {
            $("#invalid-tipo-transazione").text("");
        }
    });
});
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- ✅ FORM TRANS --}}
            @if(isset($trans))
            <form class="form-horizontal" name="trans" method="POST" action="{{ route('trans.update', ['trans' => $trans->id]) }}">
                @method('PUT')
            @else
            <form class="form-horizontal" name="trans" method="POST" action="{{ route('trans.store') }}">
            @endif
                @csrf

                {{-- 🔸 TIPO: Entrata o Spesa --}}
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="tipo_transazione">Tipo</label>
                    </div>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_transazione" required>
                            <option value="">-- Seleziona --</option>
                            <option value="entrata" @if(isset($trans) && $trans->tipo_transazione === 'entrata') selected @endif>Entrata</option>
                            <option value="spesa" @if(isset($trans) && $trans->tipo_transazione === 'spesa') selected @endif>Spesa</option>
                        </select>
                        <span class="invalid-input text-danger" id="invalid-tipo-transazione"></span>
                    </div>
                </div>

                {{-- 🔸 DESCRIZIONE --}}
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="descrizione">Descrizione</label>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="descrizione" value="{{ $trans->descrizione ?? '' }}" required>
                        <span class="invalid-input text-danger" id="invalid-descrizione"></span>
                    </div>
                </div>

                {{-- 🔸 IMPORTO --}}
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="importo">Importo</label>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="importo" value="{{ $trans->importo ?? '' }}" required>
                        <span class="invalid-input text-danger" id="invalid-importo"></span>
                    </div>
                </div>

                {{-- 🔸 DATA (con date picker) --}}
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="data">Data</label>
                    </div>
                    <div class="col-md-10">
                        <input type="date" id="data" name="data" class="form-control"
                               value="{{ isset($trans) ? \Carbon\Carbon::parse($trans->data)->format('Y-m-d') : '' }}"
                               required>
                        <span class="invalid-input text-danger" id="invalid-data"></span>
                    </div>
                </div>

                {{-- 🔸 SUBMIT --}}
                <div class="form-group row mb-3">
                    <div class="col-md-10 offset-md-2">
                        @if(isset($trans))
                        <label for="mySubmit" class="btn btn-primary w-100">
                            <i class="bi bi-floppy2-fill"></i> Salva
                        </label>
                        <input id="mySubmit" class="d-none" type="submit" value="Save" />
                        @else
                        <label for="mySubmit" class="btn btn-primary w-100">
                            <i class="bi bi-floppy2-fill"></i> Crea
                        </label>
                        <input id="mySubmit" class="d-none" type="submit" value="Create" />
                        @endif
                    </div>
                </div>

                {{-- 🔸 CANCEL --}}
                <div class="form-group row mb-3">
                    <div class="col-md-10 offset-md-2">
                        <a class="btn btn-danger w-100" href="{{ route('trans.index') }}">
                            <i class="bi bi-box-arrow-left"></i> Annulla
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
