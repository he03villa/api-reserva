<?php

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);
Route::post('/hotels', [HotelController::class, 'store']);

Route::get('/bookings/{id}', [BookingsController::class, 'index']);
Route::post('/bookings', [BookingsController::class, 'store']);
Route::put('/bookings/{bookings}', [BookingsController::class, 'edit']);
Route::put('/bookings/estado_reserva/{bookings}', [BookingsController::class, 'editEstadoReserva']);