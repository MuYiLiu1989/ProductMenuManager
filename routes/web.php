<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductManage\CategoryController;
use App\Http\Controllers\ProductManage\ItemController;
use App\Http\Controllers\Api\ProductItemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::prefix('/productManage')->group(function () {
        Route::get('/', fn() => Inertia::render('ProductManage'))->name('productManage');
        Route::resource('category', CategoryController::class, ['as' => 'productManage']);
        Route::post('category/ajax', [CategoryController::class, 'ajax'])->name('productManage.category.ajax');
        Route::resource('item', ItemController::class, ['as' => 'productManage']);
        Route::post('item/ajax', [ItemController::class, 'ajax'])->name('productManage.item.ajax');
    });
    Route::prefix('/productOrder')->group(function () {
        Route::get('/', fn() => Inertia::render('ProductOrder'))->name('productOrder');
        Route::get('menu', [OrderController::class, 'menu'])->name('productOrder.menu');
        Route::get('api',[ProductItemController::class, 'index'])->middleware('auth:sanctum')->name('productOrder.api');
        Route::match(['get','post'],'cart', [OrderController::class, 'cart'])->name('productOrder.cart');
        Route::post('ajax', [OrderController::class, 'ajax'])->name('productOrder.ajax');
        Route::post('submit',[OrderController::class, 'submitProcess'])->name('productOrder.submitProcess');
        Route::get('orderlist', [OrderController::class, 'orderlist'])->name('productOrder.orderlist');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
