<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
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

Route::get('/transaction/all', [TransactionController::class, 'getAllTransaction']);

Route::get('/customer/all', [CustomerController::class, 'getAllcustomer']);
Route::put('/customer/{id}', [CustomerController::class, 'updateCustomer']);
Route::post('/customer', [CustomerController::class, 'addCustomer']);
Route::delete('/customer/{id}', [CustomerController::class, 'deleteCustomer']);

Route::get('/category/all', [CategoryController::class, 'showAllcategory']);
Route::put('/category/{id}', [CategoryController::class, 'updateCategory']);
Route::post('/category', [CategoryController::class, 'addCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('/sales/all', [SalesController::class, 'showSales']);
Route::post('/sales', [SalesController::class, 'addSales']);


Route::get('/purchases/all', [PurchaseController::class, 'showAll']);
Route::post('/purchases', [PurchaseController::class, 'addPurchase']);
