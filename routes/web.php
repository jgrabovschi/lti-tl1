<?php

use App\Http\Controllers\InterfaceController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckSessionAccess;
use App\Policies\AccessPolicy;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.submit');
Route::delete('/profiles/{profile}', [LoginController::class, 'deleteProfile'])->name('profile.delete');


Route::middleware(CheckSessionAccess::class)->group(function () {
    // Interfaces
    Route::get('/interfaces', [InterfaceController::class, 'index'])->name('showInterfaces');
    Route::post('/interfaces', [InterfaceController::class, 'download'])->name('downloadInterfaces');
    Route::get('/interfaces/wireless', [InterfaceController::class, 'wireless'])->name('showInterfacesWireless');
    Route::post('/interfaces/wireless', [InterfaceController::class, 'downloadWireless'])->name('downloadWireless');
    Route::get('/interfaces/bridge', [InterfaceController::class, 'bridge'])->name('showInterfacesBridge');
    Route::post('/interfaces/bridge', [InterfaceController::class, 'downloadBridge'])->name('downloadBridge');
    Route::delete('/interfaces/bridge/{id}', [InterfaceController::class, 'destroyBridge'])->name('destroyBridge');
    Route::get('/interfaces/bridge/{id}', [InterfaceController::class, 'editBridge'])->name('editBridge');
    Route::put('/interfaces/create/bridge', [InterfaceController::class, 'storeBridge'])->name('storeBridge');
    Route::get('/interfaces/create/bridge', [InterfaceController::class, 'createBridge'])->name('createBridge');
    


    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



});
