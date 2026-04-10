<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LangController;

/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

require __DIR__ . '/auth.php';

Route::get('/lang/{lang}', [LangController::class, 'changeLanguage'])->name('setLang');



Route::get('/', [FrontController::class, 'getHome'])->name('home');


Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Mostra il form per creare un nuovo libro
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');

    // Salva un nuovo libro
    Route::post('/book', [BookController::class, 'store'])->name('book.store');


    // Mostra il form per modificare un libro
    Route::get('/book/{book}/edit', [BookController::class, 'edit'])->name('book.edit');

    // Aggiorna un libro esistente
    Route::put('/book/{book}', [BookController::class, 'update'])->name('book.update');
    // oppure:
    Route::patch('/book/{book}', [BookController::class, 'update']);

    // Elimina un libro
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/book/{id}/destroy/confirm', [BookController::class, 'confirmDestroy'])->name('book.destroy.confirm');
    Route::get('/ajaxBook', [BookController::class, 'ajaxCheckForBooks']);

     Route::resource('author', AuthorController::class);
        Route::get('/author/{id}/destroy/confirm', [AuthorController::class, 'confirmDestroy'])->name('author.destroy.confirm');
        Route::get('/ajaxAuthor',[AuthorController::class,'ajaxCheckForAuthors']);

});

Route::middleware(['auth', 'isRegisteredUser'])->group(function () {

    Route::get('books', [BookController::class, 'index'])->name('book.index');
    // Mostra un singolo libro (es. con id = 5)
    Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');

});






/*Route::middleware(['lang'])->group(function() {
    Route::get('/', [FrontController::class, 'getHome'])->name('home');

    Route::middleware(['auth','isRegisteredUser'])->group(function() {
        Route::resource('book', BookController::class);
        Route::get('/book/{id}/destroy/confirm', [BookController::class, 'confirmDestroy'])->name('book.destroy.confirm');
        Route::get('/ajaxBook',[BookController::class,'ajaxCheckForBooks']);

        Route::resource('author', AuthorController::class);
        Route::get('/author/{id}/destroy/confirm', [AuthorController::class, 'confirmDestroy'])->name('author.destroy.confirm');
        Route::get('/ajaxAuthor',[AuthorController::class,'ajaxCheckForAuthors']);
    });

    Route::middleware(['auth','isAdmin'])->group(function() {
        Route::resource('category', CategoryController::class);
    });
});*/

