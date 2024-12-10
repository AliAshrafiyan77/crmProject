<?php

use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ModuleFieldApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//customer
Route::post('/customer' , [CustomerApiController::class , 'store']);
Route::get('/customer' , [CustomerApiController::class , 'index']);
Route::get('/customer/export' , [CustomerApiController::class , 'export']);
Route::post('/customer/import' , [CustomerApiController::class , 'import']);


//meta fields
Route::post('/module-fields' , [ModuleFieldApiController::class , 'store']);
Route::get('/module-fields' , [ModuleFieldApiController::class , 'index']);
