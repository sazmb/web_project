@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Books\' List')

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Library</li>
<li class="breadcrumb-item active" aria-current="page">Books</li>
@endsection

@section('body')
<script>
    $(document).ready(function(){
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

            $("#bookTable tbody tr").each(function() {
                var found = false;
                if ((column == -1)||(column === undefined)) { // Selezionato "Title or author" o nessuna opzione
                    $(this).find("td").slice(0, -3).each(function() { // Escludi le ultime tre colonne
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
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Search by</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item searchOptions" href="#" data-column="0">Title</a></li>
                    <li><a class="dropdown-item searchOptions" href="#" data-column="1">Author</a></li>
                    <li><a class="dropdown-item searchOptions" href="#" data-column="-1">Title or author</a></li>
                </ul>
            </div>
            <input type="text" id="searchInput" class="form-control" aria-label="Text input with dropdown button" placeholder="Search...">
        </div>
    </div>

    <nav aria-label="Page navigation example" id="paginationNav">
        <ul class="pagination justify-content-center">
            <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
            <!-- Numeri di pagina -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
            <li>
                <select id="rowsPerPage" class="form-control justify-content-end">
                    <option value="5">5 books per page</option>
                    <option value="10">10 books per page</option>
                    <option value="15">15 books per page</option>
                    <option value="20">20 books per page</option>
                </select>
            </li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-xs-6 d-flex justify-content-end">
            <p>
                <a class="btn btn-success" href="{{ route('book.create') }}">
                    <i class="bi bi-database-add"></i> 
                    Create new book
                </a>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="bookTable" class="table table-striped table-hover">
                <col width='40%'>
                <col width='30%'>
                <col width='10%'>
                <col width='10%'>
                <col width='10%'>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($books_list as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author->lastname }}</td>
                            <td><a class="btn btn-secondary" href="{{ route('book.show', ['book' => $book->id]) }}"> Details</a></td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('book.edit',['book' => $book->id]) }}"><i class="bi bi-pencil-square"></i> Edit</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{ route('book.destroy.confirm',['id' => $book->id]) }}"><i class="bi bi-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection