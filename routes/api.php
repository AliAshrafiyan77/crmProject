<?php

use App\Http\Controllers\Api\CustomerApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/customer' , [CustomerApiController::class , 'store']);
Route::get('/customer' , [CustomerApiController::class , 'index']);
