<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::middleware('forceJsonResponse')->group(function () {
    Route::post('/subscribe', [SubscribeController::class, 'subscribe']);
    Route::post('/unsubscribe', [SubscribeController::class, 'unsubscribe']);
});