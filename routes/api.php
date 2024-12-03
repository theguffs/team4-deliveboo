<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisteredUserController; // Assicurati di importare il controller corretto

/*
|-------------------------------------------------------------------------- 
| API Routes 
|-------------------------------------------------------------------------- 
| 
| Qui registriamo le rotte API per l'applicazione. 
| Queste rotte sono caricate dal RouteServiceProvider e saranno assegnate 
| al gruppo middleware "api". 
| 
*/

/* Rotte accessibili a tutti (utenti autenticati e non) */
Route::prefix('public')->group(function () {
    // Visualizzare ristoranti
    Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index'); // Vedi tutti i ristoranti
    Route::get('restaurant/{restaurant}', [RestaurantController::class, 'show'])->name('restaurant.show'); // Vedi un singolo ristorante
    Route::get('/restaurant-categories', [RestaurantController::class, 'getCategories']);

    // Visualizzare i piatti di un ristorante
    Route::get('restaurant/{restaurant}/products', [ProductController::class, 'index'])->name('products.index'); // Vedi i prodotti di un ristorante
    Route::post('order', [OrderController::class, 'store'])->name('order.store');
});

/* Rotte di autenticazione (per utenti non autenticati) */
Route::prefix('auth')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store'])->name('auth.register'); // Registrazione dell'utente e creazione ristorante
    // Aggiungi altre rotte di autenticazione se necessarie (login, password reset, ecc.)
});

/* Rotte per utenti autenticati (ristoratori) */
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('restaurant')->group(function () {
        // Rotte per gestire il proprio ristorante
        Route::get('create', [RestaurantController::class, 'create'])->name('restaurant.create');
        Route::post('store', [RestaurantController::class, 'store'])->name('restaurant.store');
        Route::get('edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::put('update', [RestaurantController::class, 'update'])->name('restaurant.update');

        // Rotte per gestire i piatti (CRUD dei piatti del ristorante)
        Route::resource('products', ProductController::class)->except(['index', 'show']); // Le operazioni CRUD riservate ai ristoratori

        // Visualizzare e gestire ordini
        Route::get('orders', [OrderController::class, 'index'])->name('restaurant.orders.index'); // Vedi tutti gli ordini
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('restaurant.orders.show'); // Vedi un ordine specifico
        Route::post('order', [OrderController::class, 'store'])->name('order.store');

    });
});

/* Rotte per gli utenti non autenticati (clienti che vogliono ordinare) */
Route::post('order', [OrderController::class, 'store'])->name('order.store'); // Creare un ordine