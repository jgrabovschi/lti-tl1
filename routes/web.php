<?php

use App\Http\Controllers\InterfaceController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckSessionAccess;
use App\Policies\AccessPolicy;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.submit');

Route::middleware(CheckSessionAccess::class)->group(function () {
    // Interfaces
    Route::get('/interfaces', [InterfaceController::class, 'index'])->name('showInterfaces');
    Route::post('/interfaces', [InterfaceController::class, 'download'])->name('downloadInterfaces');
    Route::get('/interfaces/wireless', [InterfaceController::class, 'wireless'])->name('showInterfacesWireless');
    Route::post('/interfaces/wireless', [InterfaceController::class, 'downloadWireless'])->name('downloadWireless');


    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
