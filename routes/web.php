<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Qui registriamo le rotte web per l'applicazione. Le rotte pubbliche
| sono accessibili a tutti, mentre le rotte admin sono protette dal middleware.
|
*/

// Rotte pubbliche
Route::get('/', [MainController::class, 'index'])->name('home');

// Rotte protette per l'amministrazione
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        // Dashboard amministrativa
        Route::get('/dashboard', [AdminMainController::class, 'dashboard'])->name('dashboard');

        // Aggiungere qui eventuali altre rotte amministrative
    });

// Autenticazione (login, registrazione, ecc.)
require __DIR__.'/auth.php';