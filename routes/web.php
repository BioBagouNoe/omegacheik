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