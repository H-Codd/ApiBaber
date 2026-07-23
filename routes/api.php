<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaberController;
use App\Http\Controllers\BarberController;

Route::get('/ping', function() {
    return['pong' => true];
});
// 401
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

// Random
Route::get('/random', [BarberController::class, 'createRandom']);


// Auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/user', [AuthController::class, 'create']);

// User
Route::get('/user', [UserController::class, 'read']);
Route::put('/user', [UserController::class, 'update']);
Route::get('/user/favorites', [UserController::class, 'getFavorites']);
Route::post('/user/favorite', [UserController::class, 'addFavorite']);
Route::get('/user/appointments', [UserController::class, 'getAppointments']);

// Barber
Route::get('/babers', [BarberController::class, 'list']);
Route::get('/babers/{id}', [BarberController::class, 'one']);
Route::post('/barber/{id}/appointment', [BarberController::class, 'setAppointment']);

// Search
Route::get('/search', [BarberController::class, 'search']);