@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Authors\' List')

@section('active_MyLibrary','active')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Library</li>
<li class="breadcrumb-item active" aria-current="page">Authors</li>
@endsection

@section('body')
<script>
$(document).ready(function() {
    // keyup
    $("#searchInput").on("keyup", function() {
        //alert($("#searchInput").val());
        var value = $(this).val().toLowerCase();

        if(value!="") {
            $("#paginationNav").hide();
        } else {
            $("#paginationNav").show();
        }

        $("table tbody tr").each(function() {
            var found = false;
            $(this).find("td").slice(0,-3).each(function()
            {
                var text = $(this).text().toLowerCase();
                if(text.indexOf(value)>-1)
                {
                    found = true;
                }
            });
            $(this).toggle(found);
        });
    });
}

);
</script>

    <div class="container-fluid">
        <div class="row">
            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" aria-label="Text input" placeholder="Search...">
            </div>
        </div>

        <nav aria-label="Page navigation example" id="paginationNav">
            <ul class="pagination justify-content-center">
                <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
                <!-- Numeri di pagina -->
                <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
                <li>
                    <select id="rowsPerPage" class="form-control justify-content-end">
                        <option value="5">5 authors per page</option>
                        <option value="10">10 authors per page</option>
                        <option value="15">15 authors per page</option>
                        <option value="20">20 authors per page</option>
                    </select>
                </li>
            </ul>
        </nav>

        <div class="row">
            <div class="col-xs-6 d-flex justify-content-end">
                <p>
                    <a class="btn btn-success" href="{{ route('author.create') }}">
                        <i class="bi bi-database-add"></i>
                        Create new author</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover table-responsive">
                    <col width='70%'>
                    <col width='10%'>
                    <col width='10%'>
                    <col width='10%'>
                    <thead>
                        <tr>
                            <th>Author's name</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($authors_list as $author)
                            <tr>
                                <td>{{ $author->firstname }} {{ $author->lastname }}</td>
                                <td><a class="btn btn-secondary" href="{{ route('author.show', ['author' => $author->id]) }}">Details</a></td>
                                <td><a class="btn btn-primary" href="{{ route('author.edit',['author' => $author->id]) }}"><i class="bi bi-pencil-square"></i> Edit</a></td>
                                @if(count($author->books)==0)
                                    <td><a class="btn btn-danger" href="{{ route('author.destroy.confirm', ['id' => $author->id]) }}"><i class="bi bi-trash"></i> Delete</a></td>
                                @else
                                    <td><a class="btn btn-secondary" disabled="disabled" href="#"><i class="bi bi-ban"></i> Delete</a></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection