<?php

declare(strict_types=1);

use App\Http\Controllers\Account\BillingController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InboxController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('inbox', InboxController::class)->name('inbox');
    Route::get('customers', CustomerController::class)->name('customers');
    Route::get('profile', ProfileController::class)->name('account.profile');
    Route::get('billing', BillingController::class)->name('account.billing');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
