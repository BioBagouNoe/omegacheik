<?php

use Illuminate\Support\Facades\Route;

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
// Route pour l'import/export Excel
Route::post('lines/import', [App\Http\Controllers\LineController::class, 'import'])->name('lines.import');
Route::get('lines/export', [App\Http\Controllers\LineController::class, 'export'])->name('lines.export');

// Routes CRUD pour les lignes
Route::resource('lines', App\Http\Controllers\LineController::class);
// Import/export agences
Route::post('agencies/import', [App\Http\Controllers\AgencyController::class, 'import'])->name('agencies.import');
Route::get('agencies/export', [App\Http\Controllers\AgencyController::class, 'export'])->name('agencies.export');
// Routes CRUD pour les agences
Route::resource('agencies', App\Http\Controllers\AgencyController::class);

// Import/export navires
Route::post('ships/import', [App\Http\Controllers\ShipController::class, 'import'])->name('ships.import');
Route::get('ships/export', [App\Http\Controllers\ShipController::class, 'export'])->name('ships.export');
// Routes CRUD pour les navires
Route::resource('ships', App\Http\Controllers\ShipController::class);
Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');
