<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\UserController as PanelUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('counters', [CounterController::class, 'index'])->name('counters');
    Route::get('addresses', [AddressController::class, 'index'])->name('addresses');
    Route::get('notices', [NoticeController::class, 'index'])->name('notices');
    Route::get('polls', [PollController::class, 'index'])->name('polls');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('panel')->prefix('controlpanel')->name('panel.')->group(function () {
        Route::get('/', [PanelController::class, 'index'])->name('index');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [PanelUserController::class, 'index'])->name('index');
            Route::get('{user}/edit', [PanelUserController::class, 'edit'])->name('edit');
            Route::post('{user}/password', [PanelUserController::class, 'password'])->name('password');
            Route::patch('{user}/permissions', [PanelUserController::class, 'permissions'])->name('permissions');
            Route::patch('{user}', [PanelUserController::class, 'update'])->name('update');
        });

        Route::get('invoices', [PanelInvoiceController::class, 'index'])->name('invoices');
        Route::get('counters', [CounterController::class, 'index'])->name('counters');
        Route::get('addresses', [AddressController::class, 'index'])->name('addresses');
        Route::get('notices', [NoticeController::class, 'index'])->name('notices');
        Route::get('polls', [PollController::class, 'index'])->name('polls');
    });
});

Route::get('lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['language' => $locale]);
    }

    return back();
})->name('language');

require __DIR__.'/auth.php';
