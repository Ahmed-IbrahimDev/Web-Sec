<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\EvenNumbersController;
use App\Http\Controllers\MultiplicationController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// LinkedIn OAuth
Route::get('/auth/linkedin', [AuthController::class, 'redirectToLinkedIn'])->name('auth.linkedin');
Route::get('/auth/linkedin/callback', [AuthController::class, 'handleLinkedInCallback'])->name('auth.linkedin.callback');

// Catalog - accessible to all authenticated users (for shopping)
Route::middleware(['auth'])->group(function () {
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');
});

// Employee/Owner/Super Admin: Product Management
Route::middleware(['auth', 'role:employee|owner|super_admin|admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Dashboard (authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Purchases
    Route::post('/buy/{id}', [\App\Http\Controllers\PurchaseController::class, 'buyProduct'])->name('purchase.buy');
    Route::get('/my-purchases', [\App\Http\Controllers\PurchaseController::class, 'myPurchases'])->name('my-purchases');

    // Employee/Owner/Super Admin: Roles and permissions management
    Route::middleware(['role:employee|owner|super_admin|admin'])->group(function () {
        Route::get('/permissions', [RoleController::class, 'index'])->name('permissions');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        Route::put('/users/{id}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
        Route::delete('/users/{id}', [UserRoleController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{id}/edit', [UserRoleController::class, 'edit'])->name('users.edit');
    });
});

// Even Numbers (accessible to all)
Route::get('/even-numbers', [EvenNumbersController::class, 'index'])->name('even-numbers');
Route::post('/even-numbers/generate', [EvenNumbersController::class, 'generate'])->name('even-numbers.generate');

// Multiplication Table (accessible to all)
Route::get('/multiplication', [MultiplicationController::class, 'index'])->name('multiplication');
Route::post('/multiplication/generate', [MultiplicationController::class, 'generate'])->name('multiplication.generate');


