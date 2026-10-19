<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageCampaignController;
use App\Http\Controllers\PublicCardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VipCardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardUsageController;

Route::post('/cards/{card}/usages', [CardUsageController::class, 'store'])->name('cards.usages.store');
Route::delete('/cards/{card}/usages/{usage}', [CardUsageController::class, 'destroy'])->name('cards.usages.destroy');

// Public QR verification
Route::get('/card/{token}', [PublicCardController::class, 'show'])->name('card.public');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::redirect('/', '/login');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomerController::class);

    Route::resource('cards', VipCardController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/cards/{card}/renew', [VipCardController::class, 'renew'])->name('cards.renew');
    Route::post('/cards/{card}/cancel', [VipCardController::class, 'cancel'])->name('cards.cancel');
    Route::get('/cards/{card}/pdf', [VipCardController::class, 'pdf'])->name('cards.pdf');
    Route::post('/cards/{card}/whatsapp', [VipCardController::class, 'sendWhatsapp'])->name('cards.whatsapp');

    Route::resource('messages', MessageCampaignController::class)->only(['index', 'create', 'store', 'show']);

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
