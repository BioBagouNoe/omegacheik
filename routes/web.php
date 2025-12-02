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
// Routes CRUD pour les agences
Route::resource('agencies', App\Http\Controllers\AgencyController::class);
Route::get('/ships', function () {
    return view('ship.index');
})->name('ships');
Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');
