<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

// Public: short URL redirect (must be before catch-all)
Route::get('/{shortCode}', [ShortUrlController::class, 'redirect'])
    ->where('shortCode', '[A-Za-z0-9]{6}');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/',  [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Invitation acceptance (public link)
    Route::get('/invite/{token}',  [InvitationController::class, 'accept'])->name('invite.accept');
    Route::post('/invite/{token}', [InvitationController::class, 'acceptStore'])->name('invite.accept.store');
});

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Invitations — SuperAdmin and Admin only
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/invitations',        [InvitationController::class, 'index'])->name('invitations.index');
        Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('/invitations',       [InvitationController::class, 'store'])->name('invitations.store');
    });

    // Short URLs — all authenticated users can view the list
    Route::get('/urls',        [ShortUrlController::class, 'index'])->name('short-urls.index');
    Route::get('/urls/create', [ShortUrlController::class, 'create'])->name('short-urls.create');
    Route::post('/urls',       [ShortUrlController::class, 'store'])->name('short-urls.store');
});
