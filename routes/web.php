<?php

use App\Http\Controllers\InterfaceController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WirelessController;
use App\Http\Controllers\DnsController;
use App\Http\Controllers\AddressController;
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


    // IP Address
    Route::get('/address', [AddressController::class, 'index'])->name('showAddress');
    Route::post('/address/download', [AddressController::class, 'downloadAddress'])->name('downloadAddress');
    Route::get('/address/create', [AddressController::class, 'createAddress'])->name('createAddress');
    Route::put('/address/create', [AddressController::class, 'storeAddress'])->name('storeAddress');
    Route::delete('/address/{id}', [AddressController::class, 'destroyAddress'])->name('destroyAddress');
    Route::get('/address/{id}', [AddressController::class, 'editAddress'])->name('editAddress');
    Route::patch('/address/{id}', [AddressController::class, 'updateAddress'])->name('updateAddress');



    // DNS
    Route::get('/dns', [DnsController::class, 'index'])->name('showDns');
    Route::post('/dns/download', [DnsController::class, 'downloadDns'])->name('downloadDns');
    Route::get('/dns/add', [DnsController::class, 'AddServersDns'])->name('AddServersDns');
    Route::post('/dns/add', [DnsController::class, 'addServersRDns'])->name('addServersRDns');
    Route::get('/dns/remove', [DnsController::class, 'removeServerDns'])->name('removeServerDns');
    Route::post('/dns/remove', [DnsController::class, 'removeServerRDns'])->name('removeServerRDns');
    //Route::put('/dns/create', [DnsController::class, 'storeDns'])->name('storeDns');
    Route::post('/dns/toggle', [DnsController::class, 'toggleDns'])->name('toggleDns');
    Route::get('/dns/edit', [DnsController::class, 'editDns'])->name('editDns');
    Route::patch('/dns/update', [DnsController::class, 'updateDns'])->name('updateDns');

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



});
