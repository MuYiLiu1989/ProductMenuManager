<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductManage\CategoryController;
use App\Http\Controllers\ProductManage\ItemController;
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
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
