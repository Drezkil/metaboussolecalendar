<?php

use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{user_id}', [EventController::class, 'show']);
Route::post('/events/', [EventController::class, 'store']);
Route::post('/events/Everyday', [EventController::class, 'storeEveryday']);
Route::post('/events/Weekly', [EventController::class, 'storeWeekly']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
