<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')->group(function () {
    // Rotte per la gestione del ristorante e dei piatti
    Route::prefix('restaurant')->group(function () {
        Route::get('create', [RestaurantController::class, 'create'])->name('restaurant.create'); // Crea un ristorante
        Route::post('store', [RestaurantController::class, 'store'])->name('restaurant.store'); // Salva un ristorante
        Route::get('edit', [RestaurantController::class, 'edit'])->name('restaurant.edit'); // Modifica un ristorante
        Route::put('update', [RestaurantController::class, 'update'])->name('restaurant.update'); // Salva le modifiche

        // Gestione dei piatti del ristorante
        Route::resource('products', ProductController::class); // CRUD dei piatti
    });

    // Rotte per ordinare i piatti
    Route::post('order', [OrderController::class, 'store'])->name('order.store'); // Crea un ordine
});
