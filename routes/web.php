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
use App\Http\Controllers\Panel\CompanyController;
use App\Http\Controllers\Panel\AddressController as PanelAddressController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('dashboard');
Route::get('lang/{locale}', [PageController::class, 'language'])->name('language');

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
            Route::get('search', [PanelUserController::class, 'search'])->name('search');
            Route::post('{user}/password', [PanelUserController::class, 'password'])->name('password');
            Route::patch('{user}/permissions', [PanelUserController::class, 'permissions'])->name('permissions');
            Route::patch('{user}', [PanelUserController::class, 'update'])->name('update');
        });

        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('index');
            Route::get('create', [CompanyController::class, 'create'])->name('create');
            Route::post('create', [CompanyController::class, 'store'])->name('store');
            Route::get('search', [CompanyController::class, 'search'])->name('search');
            Route::get('{company}/edit', [CompanyController::class, 'edit'])->name('edit');
            Route::patch('{company}', [CompanyController::class, 'update'])->name('update');
            Route::post('{company}/status', [CompanyController::class, 'status'])->name('status');
        });

        Route::prefix('addresses')->name('addresses.')->group(function () {
            Route::get('/', [PanelAddressController::class, 'index'])->name('index');
            Route::get('create', [PanelAddressController::class, 'create'])->name('create');
            Route::post('create', [PanelAddressController::class, 'store'])->name('store');
            Route::get('search', [PanelAddressController::class, 'search'])->name('search');
            Route::get('{address}/edit', [PanelAddressController::class, 'edit'])->name('edit');
            Route::patch('{address}', [PanelAddressController::class, 'update'])->name('update');
            Route::delete('{address}', [PanelAddressController::class, 'destroy'])->name('destroy');
            Route::patch('{address}/managers', [PanelAddressController::class, 'managers'])->name('managers');
        });
    });
});

require __DIR__.'/auth.php';
