<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LibraryController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware(['auth:sanctum','isRegisteredUser'])->group(function() {
    Route::get('/books', [LibraryController::class, 'listBooks']);
    Route::get('/books_per_page', [LibraryController::class, 'listBooksPaginate']);
    Route::get('/books_per_page_sorted', [LibraryController::class, 'listBooksPaginateAndSort']);

    Route::get('/books_as_resources', [LibraryController::class, 'listBooksWithResources']);
    Route::get('/books_with_headers', [LibraryController::class, 'listBookWithRsponseHeaders']);

    Route::get('/books_by_category', [LibraryController::class, 'listBooksByCategory']);

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout effettuato']);
    });
});