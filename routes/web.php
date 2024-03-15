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

Route::get('/', [\App\Http\Controllers\Forntend\FrontendController::class, 'index']);

Auth::routes();

// Handle redirect register to login
// Route::match(['get','post'], '/register', function(){
//     return redirect('/login');
// });





// Route middleware
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\Profile\ProfileController::class,'index'])->name('profile.index');
    Route::get('/change-password', [\App\Http\Controllers\Profile\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/update-password', [\App\Http\Controllers\Profile\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::get('/create-profile', [\App\Http\Controllers\Profile\ProfileController::class, 'createProfile'])->name('createProfile');
    Route::post('/store-profile', [\App\Http\Controllers\Profile\ProfileController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/edit-profile', [\App\Http\Controllers\Profile\ProfileController::class, 'editProfile'])->name('editProfile');
    Route::put('/update-profile', [\App\Http\Controllers\Profile\ProfileController::class, 'updateProfile'])->name('updateProfile');


    // ('/update-password', [\App\Http\Controllers\Profile\ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Route for admin
    Route::middleware('admin')->group(function () {
        // Route for News using Resource
        Route::resource('news', NewsController::class);

        // Route for Category Using resource
        Route::resource('category', categoryController::class)->except('show');

        Route::get('/all-user',[\App\Http\Controllers\Profile\ProfileController::class, 'allUser'])->name('allUser');
        
        // Reset Password
        Route::put('/reset-password/{id}', [\App\Http\Controllers\Profile\ProfileController::class, 'resetPassword'])->name('resetPassword');
    });
});
