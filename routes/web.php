<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\HomeController;

// Route User (Homepage)
Route::get('/homepage', function () {
    return view('homepage');
});

Route::get('/welcomepage', function () {
    return view('welcomepage');
});

Route::get('/', function () {
    return view('welcome');
});

// Route Homepage dengan Data dari Database
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route untuk Admin (TANPA MIDDLEWARE - Langsung Bisa Diakses)
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // FAQ Management (CRUD)
    Route::resource('faq', FAQController::class);

    // Promosi Management (CRUD)
    Route::resource('promosi', PromosiController::class);
});

// Authentication Routes (jika diperlukan nanti)
Auth::routes();