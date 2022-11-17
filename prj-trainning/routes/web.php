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

// admin login, register, forget password
Route::prefix('admin')->group(function () {
    // admin/Login
    Route::get('login', [\App\Http\Controllers\Admin\User\LoginController::class, 'index'])->name('admin.login');
    Route::post('login/store', [\App\Http\Controllers\Admin\User\LoginController::class, 'store']);

    // admin/register
    Route::get('register', [\App\Http\Controllers\Admin\User\RegisterController::class, 'index'])->name('admin.register');
    Route::post('register/store', [\App\Http\Controllers\Admin\User\RegisterController::class, 'store']);
    Route::get('account/verify/{token}', [\App\Http\Controllers\Admin\User\RegisterController::class, 'verifyAccount'])->name('admin.user.verify');
    Route::get('register-success', [\App\Http\Controllers\Admin\User\RegisterController::class, 'registerSuccess'])->name('admin.register-succes');


    // admin/forget password
    Route::get('forgetPassword', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'index'])->name('admin.forget-password');
    Route::post('forgetPassword', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'submitForgetPasswordForm'])->name('admin.forget-password.post');
    Route::get('forgetPasswordLink/{token}/{email}', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'showResetPasswordForm'])->name('admin.forget-password-link.get');
    Route::post('reset-password', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');
    Route::get('changePasswordSuccess', [\App\Http\Controllers\Admin\User\ResetPasswordController::class, 'showChangePasswordSuccess'])->name('admin.showChangePasswordSuccess');

    // admin/logout
    Route::get('logout', [\App\Http\Controllers\Admin\User\LoginController::class, 'logout'])->name('admin.logout');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    // admin/main
    Route::get('dashboard', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin.dashboard');
    Route::get('/', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin.dashboard');

    // admin/user
    Route::prefix('user')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.list');
        Route::get('/add', [\App\Http\Controllers\Admin\UserController::class, 'add'])->name('admin.user.add');
        Route::post('/add', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');


        Route::delete('del/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');
    });

});



