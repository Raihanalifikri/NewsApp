<?php

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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::post('/updatePassword', [\App\Http\Controllers\API\AuthController::class, 'updatePassword']);
});

// Route for admin
Route::group(['middleware' => ['auth:sanctum', 'admin']], function(){

    //Route Category
    Route::post('/category/create', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::post('/category/update/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'destroy']);

    //Route News
    Route::post('/news/create', [\App\Http\Controllers\Api\NewsController::class, 'store']);
});



Route::get('/allUsers', [App\Http\Controllers\API\AuthController::class, 'allUsers']);

Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register']);

// Get data News
Route::get('/allNews', [\App\Http\Controllers\API\NewsController::class, 'index']);

// Get data by id
Route::get('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show']);

// Get data category
Route::get('/category', [\App\Http\Controllers\Api\CategoryController::class, 'index']);

// Get data by id
Route::get('/category/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);

// Get data Carousel
Route::get('/carousel', [\App\Http\Controllers\Api\FrontEndController::class, 'index']);