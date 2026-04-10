@extends('layouts.mistero') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', 'Biblios :: Books\' List')

@section('active_MyLibrary','active')



@section('body')


    

    <nav aria-label="Page navigation example" id="paginationNav" style="display: none;">
        <ul class="pagination justify-content-center">
            <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
            <!-- Numeri di pagina -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
            <li>
                <select id="rowsPerPage" class="form-control justify-content-end">
                    <option value="5">5 books per page</option>
                  
                </select>
            </li>
        </ul>
    </nav>

   <h1>Classifica Torneo 4 Squadre</h1>
   
                            <div class="mb-3">
                                <form method="POST" action="{{ route('table') }}">
                                  @csrf
                                  <button type="submit" name="action" value="init" class="btn btn-primary">Inizializza Classifica</button>
                            <button type="submit" name="action" value="reset" class="btn btn-warning">Reset Classifica</button>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#avgModal">Mostra Punteggio Medio</button>
                        </form>
                            </div>
  
<div class="row">
    <div class="col-md-12">
        @if (isset($squadre_list) && count($squadre_list) > 0)
            <table id="bookTable" class="table table-striped table-hover">
                <col width='40%'>
                <col width='30%'>
                <col width='10%'>
                <col width='10%'>
                <col width='10%'>
                <thead>
                    <tr>
                        <th>Squadra</th>
                        <th>Partite Giocate (X)</th>
                        <th>Vittorie (V)</th>
                        <th>Pareggi (N)</th>
                        <th>Sconfitte (P)</th>
                        <th>Punteggio</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($squadre_list as $squadra)
                        <tr>
                            <td>{{ $squadra->name }}</td>
                            <td>{{ $squadra->partite_giocate }}</td>
                            <td>{{ $squadra->vittorie }}</td>
                            <td>{{ $squadra->pareggi }}</td>
                            <td>{{ $squadra->sconfitte }}</td>
                            <td>{{ $squadra->punteggio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info text-center" role="alert">
                Classifica non ancora disponibile
            </div>
        @endif
    </div>
</div>



<!-- Modal punteggio medio -->
<div class="modal fade" id="avgModal" tabindex="-1" aria-labelledby="avgModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avgModalLabel">Punteggio Medio a Partita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- I dati verranno inseriti qui via JS -->
      </div>
    </div>
  </div>
</div>

@endsection