<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\registercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [registercontroller::class,'Register']);
Route::post('/login', [registercontroller::class,'login']);
Route::apiResource('/category',CategoryController::class);
Route::apiResource('/brands',BrandController::class);
Route::apiResource('/products',ProductController::class);
Route::post('/product/update/{id}',[ProductController::class,'update']);
