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
    return view('main');
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
    Route::get('/profile', [\App\Http\Controllers\Admin\MainController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [\App\Http\Controllers\Admin\MainController::class, 'profileEdit'])->name('admin.profile.edit');
    Route::post('/profile/edit', [\App\Http\Controllers\Admin\MainController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('/profile/edit-password/{id}', [\App\Http\Controllers\Admin\MainController::class, 'editPassword'])->name('admin.profile.editPassword');
    Route::post('/profile/edit-password', [\App\Http\Controllers\Admin\MainController::class, 'profileUpdatePassword'])->name('admin.profile.updatePassword');



    // admin/user
    Route::prefix('user')->group(function () {
        // manage, admin list
        Route::get('/list', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.list');
        // user list
        Route::get('/listUser', [\App\Http\Controllers\Admin\UserController::class, 'indexForUser'])->name('admin.user.listForUser');

        Route::get('/add', [\App\Http\Controllers\Admin\UserController::class, 'add'])->name('admin.user.add');
        Route::post('/add', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/update', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
        Route::get('/edit-password/{id}', [\App\Http\Controllers\Admin\UserController::class, 'editPassword'])->name('admin.user.editPassword');
        Route::post('/update-password/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.user.updatePassword');
        Route::delete('del/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');
    });

    // admin/categories
    Route::prefix('categories')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Admin\CategoriesController::class, 'index'])->name('admin.categories.list');
        Route::get('/add', [\App\Http\Controllers\Admin\CategoriesController::class, 'add'])->name('admin.categories.add');
        Route::post('/add', [\App\Http\Controllers\Admin\CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/edit/{categories}', [\App\Http\Controllers\Admin\CategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/update/{categories}', [\App\Http\Controllers\Admin\CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('del/{id}', [\App\Http\Controllers\Admin\CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    });


    // admin/post
    Route::prefix('post')->group(function () {
        Route::post('ckeditor/upload',  [\App\Http\Controllers\Admin\PostController::class, 'upload'])->name('ckeditor.upload');
        Route::get('/list', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.post.list');
        Route::get('/add', [\App\Http\Controllers\Admin\PostController::class, 'add'])->name('admin.post.add');
        Route::post('/add', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.post.store');
        Route::get('/show/{post}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('admin.post.show');
        Route::get('/edit/{post}', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.post.edit');
        Route::post('/update/{post}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.post.update');
        Route::delete('/del/{id}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.post.destroy');
    });

    // admin/comment
    Route::prefix('comment')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comment.list');
        Route::get('/active/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'active'])->name('admin.comment.active');
        Route::get('/active-all/{dataIdActive}', [\App\Http\Controllers\Admin\CommentController::class, 'activeAll'])->name('admin.comment.active-all');
        Route::get('/inactive/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'inactive'])->name('admin.comment.inactive');
        Route::get('/show/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'show'])->name('admin.comment.show');
        Route::get('/del/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comment.destroy');
//        Route::get('/edit/{post}', [\App\Http\Controllers\Admin\CommentController::class, 'edit'])->name('admin.comment.edit');
//        Route::post('/update/{post}', [\App\Http\Controllers\Admin\CommentController::class, 'update'])->name('admin.comment.update');
    });


});



