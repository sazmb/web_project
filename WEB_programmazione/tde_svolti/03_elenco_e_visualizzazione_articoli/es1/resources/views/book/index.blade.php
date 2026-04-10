@extends('layouts.mistero') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Books\' List')





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
<h1 class="text-center">Books List</h1>
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
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($books_list as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td></td>
                            <td></td>
                            <td><a class="btn btn-secondary openModalBtn" data-id="{{ $book->id }}" href="#" data-bs-toggle="modal" data-bs-target="#avgModal">Details</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
 $(document).ready(function() {
  // Variabile globale per salvare l'ID
  var currentBookId = null;
  
  // Quando clicchi su un pulsante con la classe .openModalBtn
  $('.openModalBtn').on('click', function() {
    currentBookId = $(this).data('id'); // Salva l'id del libro selezionato
     console.log("ID del libro selezionato:", currentBookId);

  });
 
  $('#avgModal').on('show.bs.modal', function() {
    var modalBody = $('#modalBody');
    modalBody.html('Caricamento...');

    if (!currentBookId) {
      modalBody.html('<p class="text-danger">ID libro non trovato.</p>');
      return;
    }

    $.ajax({
      url: '/book/' + currentBookId + '/show', // Costruisci dinamicamente la URL
      method: 'GET',
      dataType: 'json',
      headers: {
        'Accept': 'application/json'
      },
      success: function(data) {
        if (data.success && Array.isArray(data.authors)) {
          let html = '<h5>Autori per questo articolo:</h5><ul class="list-group">';
          data.authors.forEach(function(a) {
            html += `
              <li class="list-group-item">
                <strong>${a.firstname} ${a.lastname}</strong><br>
                email: <span class="text-success">${a.email}</span><br>
              </li>
            `;
          });
          html += '</ul>';
          modalBody.html(html);
        } else {
          modalBody.html('<p class="text-danger">Nessun autore disponibile.</p>');
        }
      },
      error: function() {
        modalBody.html('<p class="text-danger">Errore nel caricamento dei dati.</p>');
      }
    });
  });
});

</script>
<!-- Modal punteggio medio -->
<div class="modal fade" id="avgModal" tabindex="-1" aria-labelledby="avgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avgModalLabel">Punteggio Medio a Partita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body" id="modalBody">
        
      </div>
    </div>
  </div>
</div>
@endsection