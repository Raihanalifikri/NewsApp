<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\categoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Handle redirect register to login
// Route::match(['get','post'], '/register', function(){
//     return redirect('/login');
// });





// Route middleware
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route for admin
    Route::middleware('admin')->group(function () {
        // Route for News using Resource
        Route::resource('news', NewsController::class);

        // Route for Category Using resource
        Route::resource('category', categoryController::class);
    });
});
