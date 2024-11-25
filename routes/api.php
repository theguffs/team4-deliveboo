<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth')->group(function () {
    // Rotte per gestire il ristorante
    Route::prefix('restaurant')->group(function () {
        Route::get('create', [RestaurantController::class, 'create'])->name('restaurant.create'); // Crea un ristorante
        Route::post('store', [RestaurantController::class, 'store'])->name('restaurant.store'); // Salva un ristorante
        Route::get('edit', [RestaurantController::class, 'edit'])->name('restaurant.edit'); // Modifica un ristorante
        Route::put('update', [RestaurantController::class, 'update'])->name('restaurant.update'); // Salva le modifiche

        // Rotte per gestire i piatti del ristorante
        Route::resource('products', ProductController::class); // CRUD dei piatti del ristorante
    });
        // Rotte per utenti non autenticati (visualizza ristoranti e ordina piatti)
        Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index'); // Vedi tutti i ristoranti
        Route::get('restaurant/{restaurant}', [RestaurantController::class, 'show'])->name('restaurant.show'); // Vedi un singolo ristorante

        // Rotte per ordinare i piatti
        Route::post('order', [OrderController::class, 'store'])->name('order.store'); // Crea un ordine
});