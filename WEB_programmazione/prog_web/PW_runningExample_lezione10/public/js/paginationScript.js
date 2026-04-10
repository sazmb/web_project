$(document).ready(function() {
    var currentPage = 1;
    var tableRows = $("table tbody tr").length;
    var rowsPerPage = parseInt($("#rowsPerPage").val());
    var totalPages = Math.ceil(tableRows/rowsPerPage);

    function showPage(page) {

    }

    function goToPreviousPage() {
        if(currentPage>1)
            currentPage--;
        showPage(currentPage);
    }

    function goToNextPage() {
        if(currentPage < totalPages)
            currentPage++;
        showPage(currentPage);
    }

    // showPage(currentPage);
});