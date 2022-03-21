<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArticleController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Article controller
    Route::resource('article', ArticleController::class);

    // Order controller
    Route::resource('order', OrderController::class);

});