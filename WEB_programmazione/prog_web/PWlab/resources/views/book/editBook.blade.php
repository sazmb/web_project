@extends('layouts.masters')

@section('title')
@if (isset ($book))
    Biblios :: Edit Book
@else
    Biblios :: Add Book
    @endif
@endsection

@section('active_MyLibrary', 'active')

@section('breadcrumb')
<div class="container-fluid d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{route( 'book')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route( 'book')}}">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route( 'home')}}">Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php
                    if (isset ($_GET['id'])) {
                        echo 'Edit book';
                    } else {
                        echo 'Add book';
                    }
                    ?>
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section ('body')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" name="book" method="post" action="#">
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="title">Title</label>
                        </div>
                        <div class="col-md-10">
                          
                            @if (isset $book) 
                                echo '<input class="form-control" type="text" name="title" placeholder="Book title" value="' . $book->getTitle() . '">';
                            
                            @else 
                                echo '<input class="form-control" type="text" name="title" placeholder="Book title">';
                            
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="author_id">Author</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="author_id">
                             
                                @foreach ($authors_list as $author) 
                                    @if ((isset ($_book)) && ($author->getId() == $book->getAuthorID())) 
                                        echo '<option value="' . $author->getId() . '" selected="selected">' . $author->getLastName() . '</option>';
                                     @else 
                                        echo '<option value="' . $author->getId() . '">' . $author->getLastName() . '</option>';
                                    @endif
                                
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-2">
                            <?php
                                if (isset ($_GET['id'])) {
                                    echo '<input type="hidden" name="id" value="' . $book->getId() . '"/>';
                                    echo '<label for="mySubmit" class="btn btn-primary w-100"><i class="bi bi-floppy2-fill"></i> Save</label>';
                                    echo '<input id="mySubmit" class="d-none" type="submit" value=\'Save\'/>';
                                } else {
                                    echo '<label for="mySubmit" class="btn btn-primary w-100"><i class="bi bi-floppy2-fill"></i> Create</label>';
                                    echo '<input id="mySubmit" class="d-none" type="submit" value=\'Create\'/>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-2">
                            <a class="btn btn-danger w-100" href="books.php"><i class="bi bi-box-arrow-left"></i>
                                Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

@endsection
<?php
if (isset ($_GET['id'])) {
    echo html_head("Biblios :: Edit Book");
} else {
    echo html_head("Biblios :: Create new Book");
}
?>

<body>
    <?php
        // Caricamento del menu
        $menuItems = [
            ["name" => "Home", "link" => "../index.php"],
            ["name" => "My Library", "link" => "#", "submenu" => [
                ["name" => "Books List", "link" => "books.php"],
                ["name" => "Authors List", "link" => "../authors/authors.php"]
            ]]
        ];
        $activeIndex = [0, 1]; // My Library è attivo

        generateMenu($menuItems, $activeIndex);
    ?>

    

    <div class="container-fluid">
        <header class="header-sezione">
            <h1>
                <?php
                if (isset ($_GET['id'])) {
                    echo 'Edit Book';
                } else {
                    echo 'Create new Book';
                }
                ?>
            </h1>
        </header>
    </div>

   