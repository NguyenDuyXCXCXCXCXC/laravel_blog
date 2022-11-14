<?php

use Illuminate\Support\Facades\Route;

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



// ===Admin ===


Route::prefix('admin')->group(function () {
    // Login
    Route::get('login', [\App\Http\Controllers\Admin\User\LoginController::class, 'index'])->name('admin.login');
    Route::post('login/store', [\App\Http\Controllers\Admin\User\LoginController::class, 'store']);

    // register
    Route::get('register', [\App\Http\Controllers\Admin\User\RegisterController::class, 'index'])->name('admin.register');
    Route::post('register/store', [\App\Http\Controllers\Admin\User\RegisterController::class, 'store']);

    // forgrt password
    Route::get('forgot-password', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'index'])->name('admin.forgot-password');

    Route::get('main', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin');
});


//Route::get('admin/login', [\App\Http\Controllers\Admin\User\LoginController::class, 'index']);
//Route::post('admin/login/store', [\App\Http\Controllers\Admin\User\LoginController::class, 'store']);
//
//Route::get('admin/main', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin');
