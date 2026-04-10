@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title')
@if(isset($author))
    Biblios :: Edit Author
@else
    Biblios :: Add new author
@endif
@endsection

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('author.index') }}">Library</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('author.index') }}">Authors</a></li>
@if(isset($author))
    <li class="breadcrumb-item active" aria-current="page">Edit author</li>
@else
    <li class="breadcrumb-item active" aria-current="page">Add author</li>
@endif
@endsection

@section('body')
<script>
    $(document).ready(function() {
        $("form[name='author']").submit(function(event){
            // Espressioni regolari per verificare che i campi non contengano cifre
            var regex = /^[a-zA-Z]+$/;
            // Ottenere i valori dei campi firstName e lastName
            var firstName = $("input[name='firstName']").val();
            var lastName = $("input[name='lastName']").val();
            var error = false;
            // Verifica se il campo "lastName" è vuoto
            if(lastName.trim() === "")
            {
                error = true;
                $("#invalid-lastName").text("Il cognome dell'autore è obbligatorio");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("input[name='lastName']").focus();
            } else if(!regex.test(lastName)) {
                error = true;
                $("#invalid-lastName").text("Il cognome dell'autore non deve contenere cifre");
                event.preventDefault();
                $("input[name='lastName']").focus();
            } else {
                $("#invalid-lastName").text("");
            }

            // Verifica se il campo "firstName" è vuoto
            if(firstName.trim() === "")
            {
                error = true;
                $("#invalid-firstName").text("Il nome dell'autore è obbligatorio");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("input[name='firstName']").focus();
            } else if(!regex.test(firstName)) {
                error = true;
                $("#invalid-firstName").text("Il nome dell'autore non deve contenere cifre");
                event.preventDefault();
                $("input[name='firstName']").focus();
            } else {
                $("#invalid-firstName").text("");
            }

            if(!error)
            {
                // effettua chiamata AJAX per verificare che l'autore non sia presente nel DB
                var metodoHttp = $("input[name='_method']").val();
                if(metodoHttp === undefined) // stiamo creando un nuovo autore
                {
                    event.preventDefault();
                    $.ajax({
                        type: 'GET',
                        url: '/ajaxAuthor',
                        data: {firstName: firstName.trim(), lastName: lastName.trim()},
                        success: function(data) {
                            if(data.found)
                            {
                                error = true;
                                $("#invalid-lastName").text("L'autore è già presente nel database");
                            } else {
                                $("form[name='author']")[0].submit();
                            }
                        }
                    });
                }
            }
        });
    });
</script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(isset($author))
                <form name="author" method="post" action="{{ route('author.update', ['author' => $author->id]) }}">
                <!--<input type="hidden" name="_method" value="PUT">-->
                @method('PUT')
                @else
                <form class="form-horizontal" name="author" method="post" action="{{ route('author.store') }}">
                @endif
                @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="title">First Name</label>
                        </div>
                        <div class="col-md-10">
                            @if(isset($author))
                                <input class="form-control" type="text" name="firstName" placeholder="Author's First Name" value="{{ $author->firstname }}">
                            @else
                                <input class="form-control" type="text" name="firstName" placeholder="Author's First Name">
                            @endif
                            <span class="invalid-input" id="invalid-firstName"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="title">Last Name</label>
                        </div>
                        <div class="col-md-10">
                            @if(isset($author))
                                <input class="form-control" type="text" name="lastName" placeholder="Author's Last Name" value="{{ $author->lastname }}">
                            @else
                                <input class="form-control" type="text" name="lastName" placeholder="Author's Last Name">
                            @endif
                            <span class="invalid-input" id="invalid-lastName"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-2">
                            @if(isset($author))
                                <label for="mySubmit" class="btn btn-primary w-100"><i class="bi bi-floppy2-fill"></i> Save</label>
                                <input id="mySubmit" class="d-none" type="submit" value="Save"/>
                            @else
                                <label for="mySubmit" class="btn btn-primary w-100"><i class="bi bi-floppy2-fill"></i> Create</label>
                                <input id="mySubmit" class="d-none" type="submit" value="Create"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-2">
                            <a class="btn btn-danger w-100" href="{{ route('author.index') }}"><i class="bi bi-box-arrow-left"></i>
                                Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection