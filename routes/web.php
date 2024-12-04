<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Rotte pubbliche (visibili a tutti)
Route::get('/', [MainController::class, 'index'])->name('home'); // Homepage dei ristoranti

// Rotte pubbliche per gli ordini (per utenti non autenticati)
Route::prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::post('/', [OrderController::class, 'store'])->name('store'); // Creazione di un nuovo ordine
        Route::get('/', [OrderController::class, 'index'])->name('index'); // Recupero degli ordini tramite query string
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

        // Gestione dei prodotti
        Route::get('products/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('products', [ProductController::class, 'store'])->name('product.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::put('/products/{id}/toggle-visibility', [ProductController::class, 'toggleVisibility'])->name('product.toggleVisibility');
        Route::get('/products/{id}/show', [ProductController::class, 'show'])->name('product.show');

        // Ordini per ristorante
        Route::get('/restaurants/{restaurantId}/orders', [OrderController::class, 'indexByRestaurant'])->name('orders.restaurant');

        // Gestione degli ordini
        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index'); // Elenco ordini
                Route::get('/{id}', [OrderController::class, 'show'])->name('show'); // Dettagli di un ordine
                Route::put('/{id}', [OrderController::class, 'update'])->name('update'); // Aggiorna lo stato dell'ordine
                Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy'); // Elimina un ordine
            });
    });

// Autenticazione
require __DIR__.'/auth.php'; // Include il file che gestisce le rotte di autenticazione come il logout

