<?php

use App\Http\Controllers\AuthController; // Add this
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;

// Routes for non-authenticated users
// The '/' route can redirect to login if not logged in, or welcome if logged in
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout route (protected later with middleware if needed, but accessible for now)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected Routes (example) - typically you'd group these with Auth middleware
Route::middleware('auth')->group(function () {
    // Example: Welcome or Dashboard page after login
    Route::get('/welcome', function () {
        return view('welcome'); // Create a 'welcome.blade.php' view
    })->name('welcome');
    
    // Example Admin Dashboard route
  

    // Other routes
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/comment', function () {
        return view('comment');
    });
    Route::get('/kontak', function () {
        return view('kontak');
    });

    
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Di web.php
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/produk/kategori/{kategori}', [ProdukController::class, 'kategori'])->name('produk.kategori');  

Route::get('/comment', [UlasanController::class, 'index'])->name('comment');
Route::post('/comment', [UlasanController::class, 'store'])->name('comment.store');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// Route untuk admin (opsional)
Route::get('/admin/pesans', [KontakController::class, 'list'])->name('admin.pesans');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Produk Routes
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');

// Admin only routes
Route::middleware(['auth'])->group(function () {
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});