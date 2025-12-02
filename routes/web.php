<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;



Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Page d'inscription
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// Traitement du formulaire d'inscription
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/manifest-details', function () {
    return view('manifest_detail.index');
})->name('manifest-details');
Route::get('/manifests', function () {
    return view('manifest.index');
})->name('manifests');
// Routes CRUD pour les lignes
Route::resource('lines', App\Http\Controllers\LineController::class);
// Routes CRUD pour les agences
Route::resource('agencies', App\Http\Controllers\AgencyController::class);

// Route pour l'import Excel
Route::post('lines/import', [App\Http\Controllers\LineController::class, 'import'])->name('lines.import');
Route::get('/ships', function () {
    return view('ship.index');
})->name('ships');
Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');
