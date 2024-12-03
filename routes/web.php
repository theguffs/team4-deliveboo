<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
| Qui registriamo le rotte web per l'applicazione. Le rotte pubbliche
| sono accessibili a tutti, mentre le rotte admin sono protette dal middleware.
*/

// Rotte pubbliche (visibili a tutti)
Route::get('/', [MainController::class, 'index'])->name('home'); // Homepage dei ristoranti

// Rotte pubbliche per gli ordini (per utenti non autenticati)
Route::prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::post('/', [OrderController::class, 'store'])->name('store'); // Creazione di un nuovo ordine
    });

// Rotte per la registrazione e il login
Route::get('register', [RegisteredUserController::class, 'create'])->name('register'); // Vedi la vista di registrazione
Route::post('register', [RegisteredUserController::class, 'store']); // Crea un nuovo utente

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login'); // Vedi la vista di login
Route::post('login', [AuthenticatedSessionController::class, 'store']); // Effettua il login

// Rotte protette per l'amministrazione
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth') // Protegge tutte le rotte sottostanti, solo gli utenti autenticati possono accedervi
    ->group(function () {

        // Dashboard amministrativa
        Route::get('/dashboard', [RestaurantController::class, 'index'])->name('dashboard');

        // Rotte per gestire i prodotti (solo CRUD dei prodotti)
        Route::get('products/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('products', [ProductController::class, 'store'])->name('product.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        // Route per toggle della visibilità del prodotto
        Route::put('/products/{id}/toggle-visibility', [ProductController::class, 'toggleVisibility'])->name('product.toggleVisibility');
        Route::get('/products/{id}/show', [ProductController::class, 'show'])->name('product.show');

        // Rotte amministrative per la gestione degli ordini
        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index'); // Elenco ordini
                Route::get('/{id}', [OrderController::class, 'show'])->name('show'); // Dettagli di un ordine
                Route::put('/{id}', [OrderController::class, 'update'])->name('update'); // Aggiorna lo stato dell'ordine
                Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy'); // Elimina un ordine
            });
        Route::get('/restaurant/{restaurantId}/orders', [RestaurantController::class, 'getOrders']);
    });

// Autenticazione (gestito automaticamente da Laravel)
require __DIR__.'/auth.php'; // Include il file che gestisce le rotte di autenticazione come il logout
