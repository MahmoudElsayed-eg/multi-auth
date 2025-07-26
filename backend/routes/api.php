<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//login
Route::post('/users/login', [UserAuthController::class, 'login']);
Route::post('/admins/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // get user
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:user');

    // get admin
    Route::get('/admin', function (Request $request) {
        return $request->user('admin');
    })->middleware('auth:admin');

    //logout
    Route::delete('/users/logout', [UserAuthController::class, 'logout'])->middleware('auth:user');
    Route::delete('/admins/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');

    //post
    Route::apiResource('/posts', PostController::class)->except(['index', 'show']);

    //admin dashboard
    Route::get('/admins', AdminDashboardController::class)->middleware('auth:admin');

    //user dashboard
    Route::get('/users', UserDashboardController::class)->middleware('auth:user');
});
