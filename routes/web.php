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
// Routes CRUD pour les lignes
Route::resource('lines', App\Http\Controllers\LineController::class);

// Route pour l'import Excel
Route::post('lines/import', [App\Http\Controllers\LineController::class, 'import'])->name('lines.import');
Route::get('/agencies', function () {
    return view('agency.index');
})->name('agencies');
Route::get('/ships', function () {
    return view('ship.index');
})->name('ships');
Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');