<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CatalogController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', function () {
        return Inertia::render('Cart');
    })->name('cart');
    Route::get('/checkout', function () {
        return Inertia::render('Checkout');
    })->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

require __DIR__.'/auth.php';

Route::get('/{any}', function () {
    return Inertia::render('Welcome');
})->where('any', '.*');
