<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
     <!-- Fogli di stile -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/style.css">
    <!-- jQuery e plugin JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>   
    <script src="http://' . $_SERVER['HTTP_HOST'] . '/PW_runningExample_2025.04.03/js/bootstrap.min.js"></script>
     <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Biblios</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link @yield ('active_home')" aria-current="page" href="index.html">Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @yield ('active_mylibrary')" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      My Library
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="books/books.html">Books List</a></li>
                      <li><a class="dropdown-item" href="authors/authors.html">Authors List</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
        </nav>

        <div class="container-fluid d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                   @yield ('breadcrumb')
                </ol>
            </nav>
        </div>
        
        <div class="container-fluid">
            <header class="header-sezione">
                <h1>
                   @yield ('title')
                </h1>
            </header>
        </div>

        @yield ('body')

               
                </div>
            </div>
        </div>
    </body>
</html>