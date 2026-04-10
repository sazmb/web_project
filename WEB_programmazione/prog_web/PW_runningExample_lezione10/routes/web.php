<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

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

require __DIR__.'/auth.php';

Route::get('/', [FrontController::class, 'getHome'])->name('home');

Route::middleware(['auth','isRegisteredUser'])->group(function() {
    Route::resource('book', BookController::class);
    Route::get('/book/{id}/destroy/confirm', [BookController::class, 'confirmDestroy'])->name('book.destroy.confirm');
    Route::get('/ajaxBook',[BookController::class, 'ajaxCheckForBooks']);

    Route::resource('author', AuthorController::class);
    Route::get('/author/{id}/destroy/confirm', [AuthorController::class, 'confirmDestroy'])->name('author.destroy.confirm');
});

Route::middleware(['auth','isAdmin'])->group(function() {
    Route::resource('category', CategoryController::class);
});
