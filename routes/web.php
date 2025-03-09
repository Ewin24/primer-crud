<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PurchaseController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('clients', ClientController::class);


// Rutas personalizadas para Purchases
Route::prefix('purchases')->group(function () {
    Route::get('/{client}/product/{product}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/{client}/product/{product}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/{client}/product/{product}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
});

// Mantener el resource para create/store/index
Route::resource('purchases', PurchaseController::class)->except(['edit', 'update', 'destroy']);