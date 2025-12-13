<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\TravelController;

// ====================
// Routes publiques (accessibles sans être connecté)
// ====================

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Register
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');


// ====================
// Routes protégées (nécessite d'être authentifié)
// ====================

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Manifestes
    Route::resource('travels', TravelController::class);
    Route::view('/manifests', 'manifest.index')->name('manifests');
    Route::view('/manifest-details', 'manifest_detail.index')->name('manifest-details');

    // Navires
Route::resource('ships', ShipController::class);
Route::post('ships/import', [ShipController::class,'import'])->name('ships.import');
Route::get('ships/export', [ShipController::class,'export'])->name('ships.export');

    // Profil utilisateur
    Route::view('/profile', 'user.profile')->name('profile');

    // CRUD Lignes
    Route::resource('lines', LineController::class);

    // CRUD Agences
    Route::resource('agencies', AgencyController::class);

    // Import Excel des lignes
    Route::post('lines/import', [LineController::class, 'import'])
        ->name('lines.import');
    Route::get('lines/export', [LineController::class, 'export'])->name('lines.export');
    // Import/export agences
    Route::post('agencies/import', [AgencyController::class, 'import'])->name('agencies.import');
    Route::get('agencies/export', [AgencyController::class, 'export'])->name('agencies.export');
});