<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategorieController;

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


// public routes

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

//categories
Route::get('/categories', [CategorieController::class,'index']);
Route::post('/categories/store', [CategorieController::class,'store']);
Route::put('/categories/{id}', [CategorieController::class,'update']);
Route::delete('/categories/{id}', [CategorieController::class,'destroy']);
Route::get('/categories/{id}', [CategorieController::class,'show']);


// product




// protected routes

Route::group(['middleware' => ['auth:sanctum']],function(){

    Route::post('/logout/{id}',[AuthController::class, 'logout']);

    // product
    Route::get('/products',[ProductController::class,'index']);
    Route::post('/product/store',[ProductController::class,'store']);
    Route::get('/product/{id}',[ProductController::class,'show']);
    Route::put('/product/{id}',[ProductController::class,'update']);
    Route::delete('/product/{id}',[ProductController::class,'destroy']);

});