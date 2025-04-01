<?php

use App\Http\Controllers\InterfaceController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WirelessController;
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
    Route::patch('/interfaces/bridge/{id}', [InterfaceController::class, 'updateBridge'])->name('updateBridge');
    Route::delete('/interfaces/bridge/{id}', [InterfaceController::class, 'destroyBridge'])->name('destroyBridge');
    Route::get('/interfaces/bridge/{id}', [InterfaceController::class, 'editBridge'])->name('editBridge');
    Route::put('/interfaces/create/bridge', [InterfaceController::class, 'storeBridge'])->name('storeBridge');
    Route::get('/interfaces/create/bridge', [InterfaceController::class, 'createBridge'])->name('createBridge');
    Route::put('/interfaces/bridge/port', [InterfaceController::class, 'addPortBridge'])->name('addPortBridge');
    Route::delete('/interfaces/bridge/port/{id}', [InterfaceController::class, 'destroyPortBridge'])->name('destroyPortBridge');


    //ROutes Statics
    Route::get('/routes', [StaticController::class, 'index'])->name('showStatics');
    Route::post('/routes/download', [StaticController::class, 'downloadStatic'])->name('downloadStatic');
    Route::put('/routes/create', [StaticController::class, 'storeStatic'])->name('storeStatic');
    Route::get('/routes/create', [StaticController::class, 'createStatic'])->name('createStatic');
    Route::get('/routes/{id}', [StaticController::class, 'editStatic'])->name('editStatic');
    Route::delete('/routes/{id}', [StaticController::class, 'destroyStatic'])->name('destroyStatic');
    Route::patch('/routes/{id}', [StaticController::class, 'updateStatic'])->name('updateStatic');
    
    

    // Wireless
    Route::put('/wireless/enable/{id}', [WirelessController::class, 'enable'])->name('enableWireless');
    Route::put('/wireless/disable/{id}', [WirelessController::class, 'disable'])->name('disableWireless');
    Route::get('/interfaces/wireless/config/{id}', [WirelessController::class, 'config'])->name('configWireless');
    Route::patch('/interfaces/wireless/config/{id}', [WirelessController::class, 'update'])->name('saveConfigWireless');


    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



});
