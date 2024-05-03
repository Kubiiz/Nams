<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/bills', [BillController::class, 'index'])->name('bills');
    Route::get('/counters', [CounterController::class, 'index'])->name('counters');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices');
    Route::get('/polls', [PollController::class, 'index'])->name('polls');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('controlpanel')->name('panel.')->group(function () {
        Route::get('/', [PanelController::class, 'index'])->name('index');
    });
});

require __DIR__.'/auth.php';
