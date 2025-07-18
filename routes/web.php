<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ImportController;




Route::get('/', [CustomerController::class, 'index'])->name('home'); // Trang chủ công khai

Route::middleware('customer')->group(function () {
    Route::get('/index', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/books', [CustomerController::class, 'books'])->name('books');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::resource('books', BookController::class)->names([
            'index' => 'admin.books.index',
            'create' => 'admin.books.create',
            'store' => 'admin.books.store',
            'show' => 'admin.books.show',
            'edit' => 'admin.books.edit',
            'update' => 'admin.books.update',
            'destroy' => 'admin.books.destroy',
        ]);

        Route::resource('authors', AuthorController::class)->names([
            'index' => 'admin.authors.index',
            'create' => 'admin.authors.create',
            'store' => 'admin.authors.store',
            'edit' => 'admin.authors.edit',
            'update' => 'admin.authors.update',
            'destroy' => 'admin.authors.destroy',
        ]);

        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);
        

        Route::resource('promotions', PromotionController::class)->names([
            'index' => 'admin.promotions.index',
            'create' => 'admin.promotions.create',
            'store' => 'admin.promotions.store',
            'edit' => 'admin.promotions.edit',
            'update' => 'admin.promotions.update',
            'destroy' => 'admin.promotions.destroy',
        ]);
        Route::post('/promotions/apply', [PromotionController::class, 'applyToBooks'])->name('admin.promotions.apply');
        Route::get('/history', [PromotionController::class, 'showPromotionHistory'])->name('admin.promotions.history');
        Route::get('/history/export', [PromotionController::class, 'exportHistory'])->name('admin.promotions.history.export');
        Route::delete('/promotions/history/{id}', [PromotionController::class, 'deletePromotionHistory'])->name('admin.promotions.history.delete');

        Route::resource('imports', ImportController::class)->names([
            'index' => 'admin.imports.index',
            'create' => 'admin.imports.create',
            'store' => 'admin.imports.store',
            'edit' => 'admin.imports.edit',
            'update' => 'admin.imports.update',
            'destroy' => 'admin.imports.destroy',
        ]);
        Route::get('/admin/imports/{import}', [ImportController::class, 'show'])->name('imports.show');


        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
        Route::put('/admin/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

require __DIR__.'/auth.php';