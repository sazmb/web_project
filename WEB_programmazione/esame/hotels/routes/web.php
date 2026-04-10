<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReviewController;



require __DIR__ . '/auth.php';

Route::get('/lang/{lang}', [LangController::class, 'changeLanguage'])->name('setLang');



Route::get('/', [FrontController::class, 'getHome'])->name('home');


Route::middleware(['auth', 'isAdmin'])->group(function () {

    // HOTEL ROUTES (ADMIN)
    

    Route::get('/hotel/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/hotel', [HotelController::class, 'store'])->name('hotel.store');

    Route::get('/hotel/{hotel}/edit', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::put('/hotel/{hotel}', [HotelController::class, 'update'])->name('hotel.update');
    Route::patch('/hotel/{hotel}', [HotelController::class, 'update']);

    Route::get('/hotel/{id}/destroy/confirm', [HotelController::class, 'confirmDestroy'])->name('hotel.destroy.confirm');
    Route::delete('/hotel/{hotel}', [HotelController::class, 'destroy'])->name('hotel.destroy');

    Route::get('/hotel/{hotel}', [HotelController::class, 'show'])->name('hotel.show'); // Visualizza hotel + recensioni
});

Route::middleware(['auth', 'isRegisteredUser'])->group(function () {

    // HOTEL ROUTES (UTENTE)
 
   

    // REVIEW ROUTES (UTENTE)
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    
    Route::get('/review/create/{hotel}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::patch('/review/{review}', [ReviewController::class, 'update']);

    Route::get('/review/{id}/destroy/confirm', [ReviewController::class, 'confirmDestroy'])->name('review.destroy.confirm');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::get('/reviewHotel/{hotel}', [ReviewController::class, 'findReviewByHotel'])->name('review.indexHotel'); // tutte le review dell’utente

    Route::get('/review/{review}', [ReviewController::class, 'show'])->name('review.show'); // dettaglio singola review

    // AJAX check se utente ha già recensito un hotel
    Route::get('/ajaxReviewCheck', [ReviewController::class, 'ajaxCheckUserHasReviewed'])->name('ajaxReviewCheck');

});








