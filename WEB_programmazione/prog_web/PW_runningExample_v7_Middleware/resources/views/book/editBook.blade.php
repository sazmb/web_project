@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title')
@if(isset($book))
    Biblios :: Edit Book
@else
    Biblios :: Add new book
@endif
@endsection

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('book.index') }}">Library</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('book.index') }}">Books</a></li>
@if(isset($book))
    <li class="breadcrumb-item active" aria-current="page">Edit book</li>
@else
    <li class="breadcrumb-item active" aria-current="page">Add book</li>
@endif
@endsection

@section('body')
<sript>
    $(document).ready(function(){
        $("form[name='book']").submit(funtion(event){           // la form  punta alla prima della pagina in questo quella del logout
                                                                // perchè messa in alto se voglio un alte form lo devo specificare 

        event.preventDefault(); // previene l'invio della form
        var title= $("input[name='title']").val();
        var error =false;
        var regex= /[a-zA-Z]+$/;

        if (title.val().trim()==""){
            error= true;
            $("#invalid-title").text("Il titolo è obbligatorio");
           title.focus();
        } else if(!regex.test(title.val())){                          //da rimuovere questo serve solo sui nomi degli a
            error= true;
            $("#invalid-title").text("Il titolo può contenere solo lettere");
            title.focus();
        } else{
            $("#invalid-title").text("");
        }

        if($("select[name='categories[]'] option:selected").length == 0){
            error= true;
            $("#invalid-category").text("La categoria è obbligatoria");
            $("select[name='categories[]']").focus();
        }   else{
            $("#invalid-category").text("");
        }
        if (!error){

            var metodoHttp=$("form[name='_method']").val(); // prendo il metodo della form, se è post o put
            if (metodoHttp === undefined ){ // se è put allora devo fare un update
               $.ajax({
                type: "GET",
                url: 'ajaxBook',
                data: {title : title.val().trim()}
               });
            } else { // altrimenti è post e devo fare un create
                $("form[name='book']").attr("action", "{{ route('book.store') }}");
            }
           
            //$("form[name='book']")[0].submit(); // se non ci sono errori invia la form, uso l'indice 0 per indicare solo la prima
                                                // prima non ne avevo bisogno perhè serviva per associare la logica a tutte le form book (se togli lo 0 non va)
        }
        
    });
});
</script>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(isset($book))
                <form class="form-horizontal" name="book" method="post" action="{{ route('book.update', ['book' => $book->id]) }}">
                <!--<input type="hidden" name="_method" value="PUT">-->
                @method('PUT')
                @else
                <form class="form-horizontal" name="book" method="post" action="{{ route('book.store') }}">
                @endif
                @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="categories">Categories</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" multiple="multiple" name="categories[]">
                            @foreach($categories as $cat)
                                @if((isset($book->id))&&($book->categories->contains($cat)))
                                    <option value="{{ $cat->id }}" selected="selected">{{ $cat->name }}</option>
                                @else
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endif
                            @endforeach                    
                            </select>
                            <span class="invalid-input" id= "invalid-category"> </span>
                        </div>
                        
                            
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="title">Title</label>
                        </div>
                        <div class="col-md-10">
                            @if(isset($book))
                                <input class="form-control" type="text" name="title" value="{{ $book->title }}"/>
                            @else
                                <input class="form-control" type="text" name="title"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="author_id">Author</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="author_id">
                                @foreach($authorList as $author)
                                    @if((isset($book))&&($author->id == $book->author_id))
                                        <option value="{{ $author->id }}" selected="selected">{{ $author->lastname }}</option>
                                    @else
                                        <option value="{{ $author->id }}">{{ $author->lastname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-2">
                            @if(isset($book))
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
                            <a class="btn btn-danger w-100" href="{{ route('book.index') }}"><i class="bi bi-box-arrow-left"></i>
                                Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection