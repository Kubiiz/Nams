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

    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::middleware('panel')->prefix('controlpanel')->name('panel.')->group(function () {
        Route::get('/', [PanelController::class, 'index'])->name('index');

        Route::middleware('admin')->prefix('users')->name('users.')->controller(PanelUserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('search', 'search')->name('search');
            Route::get('{user}/edit', 'edit')->name('edit');
            Route::post('{user}/password', 'password')->name('password');
            Route::patch('{user}/permissions', 'permissions')->name('permissions');
            Route::patch('{user}', 'update')->name('update');
        });

        Route::middleware('owner')->prefix('companies')->name('companies.')->controller(CompanyController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('search', 'search')->name('search');
            Route::get('create', 'create')->name('create')->middleware('admin');
            Route::post('create', 'store')->name('store')->middleware('admin');
            Route::get('{company}/edit', 'edit')->name('edit');
            Route::patch('{company}', 'update')->name('update');
            Route::post('{company}/status', 'status')->name('status')->middleware('admin');;
        });

        Route::prefix('addresses')->name('addresses.')->controller(PanelAddressController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('search', 'search')->name('search');
            Route::get('{address}/edit', 'edit')->name('edit');
            Route::post('{address}/status', 'status')->name('status')->middleware('admin');

            Route::middleware('owner')->group(function () {
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::patch('{address}', 'update')->name('update');
                Route::patch('{address}/settings', 'settings')->name('settings');
                Route::post('{address}/managers', 'managerCreate')->name('manager.create');
                Route::delete('{address}/managers', 'managerDestroy')->name('manager.destroy');
            });
        });
    });
});

require __DIR__.'/auth.php';
