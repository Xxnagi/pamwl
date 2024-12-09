<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TransactionController;

Route::get('/products/all', [ProductController::class, 'getAllProducts']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::post('/products', [ProductController::class, 'addProduct']);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
Route::get('/categories/{categoryId}/products', [ProductController::class, 'getProductsByCategory']);
Route::get('/suppliers/{supplierId}/products', [ProductController::class, 'getProductsBySupplier']);

Route::get('/suppliers/all', [SupplierController::class, 'getAllSuppliers']);
Route::put('/suppliers/{id}', [SupplierController::class, 'updateSupplier']);
Route::post('/suppliers', [SupplierController::class, 'addSupplier']);
Route::delete('/suppliers/{id}', [SupplierController::class, 'deleteSupplier']);

// Route untuk menambahkan kategori
Route::post('/categories', [CategoryController::class, 'addCategory']);
Route::get('/categories', [CategoryController::class, 'showAllCategory']);
Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('/purchases/total', [PurchaseController::class, 'getTotalPurchase']);
Route::get('/purchases/all', [PurchaseController::class, 'showAll']);
Route::get('/purchases/{id}', [PurchaseController::class, 'getPurchaseById']);
Route::post('/purchases', [PurchaseController::class, 'addPurchase']);

Route::get('/transactions', [TransactionController::class, 'getAllTransaction']);
