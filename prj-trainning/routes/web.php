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
    Route::get('account/verify/{token}', [\App\Http\Controllers\Admin\User\RegisterController::class, 'verifyAccount'])->name('admin.user.verify');
    Route::get('register-success', [\App\Http\Controllers\Admin\User\RegisterController::class, 'registerSuccess'])->name('admin.register-succes');


    // forget password
    Route::get('forgetPassword', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'index'])->name('admin.forget-password');
    Route::post('forgetPassword', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'submitForgetPasswordForm'])->name('admin.forget-password.post');
    Route::get('forgetPasswordLink', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'showResetPasswordForm'])->name('admin.forget-password-link');
    Route::get('changePasswordSuccess', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'showChangePasswordSuccess'])->name('admin.showChangePasswordSuccess');

    Route::get('main', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin');


});




