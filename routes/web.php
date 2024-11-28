<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Qui registriamo le rotte web per l'applicazione. Le rotte pubbliche
| sono accessibili a tutti, mentre le rotte admin sono protette dal middleware.
|
*/

// Rotte pubbliche (visibili a tutti)
Route::get('/', [MainController::class, 'index'])->name('home'); // Homepage dei ristoranti

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
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->middleware(['auth'])->name('dashboard');

        // Aggiungere qui eventuali altre rotte amministrative (gestione ristoranti, piatti, ecc.)
    });

// Autenticazione (gestito automaticamente da Laravel)
require __DIR__.'/auth.php'; // Include il file che gestisce le rotte di autenticazione come il logout