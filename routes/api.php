<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ProductItemController;

Route::get('/user', function (Request $request) {
    return ['data' => User::all(),
        'meta' => [
            'status' => 'success',
            'requested_at' => now(),
            'count' => User::count()
        ]
    ];
})->middleware('auth:sanctum');

Route::post('login',[ApiController::class, 'getToken'])->middleware(['web', 'auth']);
//套用web的middleware，使之可以讀到Auth::user()
Route::get('route',[ApiController::class, 'route']);
Route::get('categoryId',[ApiController::class, 'categoryId']);

Route::middleware(['auth:sanctum'])->group(function () {
	Route::get('productItem',[ProductItemController::class, 'index']);
});
