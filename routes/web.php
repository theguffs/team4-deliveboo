<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;

Route::get('/', [RestaurantController::class, 'index'])->name('home');  // Homepage che mostra i ristoranti

Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index'); // Vedi tutti i ristoranti (pubblico)
Route::get('restaurant/{restaurant}', [RestaurantController::class, 'show'])->name('restaurant.show'); // Vedi un singolo ristorante