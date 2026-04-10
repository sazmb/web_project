@extends('layouts.master') <!-- title - active_home - active_Hotels - breadcrumb - body -->

@section('title', 'HotelExplorer :: Hotels List')

@section('active_Hotels','active')


@section('body')
<script>
    $(document).ready(function(){
        // Searching feature
        $(".searchOptions").on("click", function(e) {
            e.preventDefault();
            var column = $(this).attr("data-column");
            $("#searchInput").attr("data-column", column);
            $("#searchInput").attr("placeholder", "Search " + $(this).text().toLowerCase() + "...");
            $("#searchInput").trigger("keyup"); // Re-execute search when column changes
        });

        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();

            if (value !== "") {
                $("#paginationNav").hide();
            } else {
                $("#paginationNav").show();
                currentPage = 1; // Reset to first page
                return;
            }
            
            var column = $("#searchInput").attr("data-column");

            $("#hotelTable tbody tr").each(function() {
                var found = false;
                if ((column == -1)||(column === undefined)) { // "Name or Location" or no option selected
                    $(this).find("td").slice(0, -2).each(function() { // Exclude last two columns (actions)
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



    <nav aria-label="Page navigation example" id="paginationNav">
        <ul class="pagination justify-content-center">
            <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
            <!-- Page numbers can be dynamically inserted here -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
            <li>
                <select id="rowsPerPage" class="form-control justify-content-end">
                    <option value="5">5 hotels per page</option>
                    <option value="10">10 hotels per page</option>
                    <option value="15">15 hotels per page</option>
                    <option value="20">20 hotels per page</option>
                </select>
            </li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-xs-6 d-flex justify-content-end">
            @if (auth()->check() && auth()->user()->role === 'admin')
            <p>
                <a class="btn btn-success" href="{{ route('hotel.create') }}">
                    <i class="bi bi-building-add"></i> 
                    Create new hotel
                </a>
            </p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="hotelTable" class="table table-striped table-hover">
                <col width='40%'>
                <col width='30%'>
                <col width='15%'>
                <col width='15%'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th></th> <!-- Details -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <th></th> <!-- Edit -->
                        <th></th> <!-- Delete -->
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach ($hotels_list as $hotel)
                        <tr>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->location }}</td>
                            <td>
                                <a class="btn btn-secondary" href="{{ route('hotel.show', ['hotel' => $hotel->id]) }}">
                                    Details
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-secondary" href="{{ route('review.indexHotel', ['hotel' => $hotel->id]) }}">
                                    Reviews
                                </a>
                            </td>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                            <td>
                                <a class="btn btn-primary" href="{{ route('hotel.edit', ['hotel' => $hotel->id]) }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{ route('hotel.destroy.confirm', ['id' => $hotel->id]) }}">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
