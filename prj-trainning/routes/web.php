<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\User\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\User\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\User\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\MainController as UserMainController;
use App\Http\Controllers\AuthController as UserAuthController;
use App\Http\Controllers\ProfileController as UserProfileController;
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

//Route::get('/', function () {
//    return view('main');
//});



// ==================================== Admin ==================================

// admin login, register, forget password
Route::prefix('admin')->group(function () {
    // admin/Login
    Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('login/store', [AdminLoginController::class, 'store']);

    // admin/register
    Route::get('register', [AdminRegisterController::class, 'index'])->name('admin.register');
    Route::post('register/store', [AdminRegisterController::class, 'store']);
    Route::get('account/verify/{token}', [AdminRegisterController::class, 'verifyAccount'])->name('admin.user.verify');
    Route::get('register-success', [AdminRegisterController::class, 'registerSuccess'])->name('admin.register-succes');


    // admin/forget password
    Route::get('forgetPassword', [AdminResetPasswordController::class, 'index'])->name('admin.forget-password');
    Route::post('forgetPassword', [AdminResetPasswordController::class, 'submitForgetPasswordForm'])->name('admin.forget-password.post');
    Route::get('forgetPasswordLink/{token}/{email}', [AdminResetPasswordController::class, 'showResetPasswordForm'])->name('admin.forget-password-link.get');
    Route::post('reset-password', [AdminResetPasswordController::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');
    Route::get('changePasswordSuccess', [AdminResetPasswordController::class, 'showChangePasswordSuccess'])->name('admin.showChangePasswordSuccess');

    // admin/logout
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});


Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin']], function(){
    // admin/main
    Route::get('dashboard', [AdminMainController::class, 'index'])->name('admin.dashboard');
    Route::get('/', [AdminMainController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminMainController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [AdminMainController::class, 'profileEdit'])->name('admin.profile.edit');
    Route::post('/profile/edit', [AdminMainController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('/profile/edit-password/{id}', [AdminMainController::class, 'editPassword'])->name('admin.profile.editPassword');
    Route::post('/profile/edit-password', [AdminMainController::class, 'profileUpdatePassword'])->name('admin.profile.updatePassword');



    // admin/user
    Route::prefix('user')->group(function () {
        // manage, admin list
        Route::get('/list', [AdminUserController::class, 'index'])->name('admin.list');
        // user list
        Route::get('/listUser', [AdminUserController::class, 'indexForUser'])->name('admin.user.listForUser');

        Route::get('/add', [AdminUserController::class, 'add'])->name('admin.user.add');
        Route::post('/add', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/update', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::get('/edit-password/{id}', [AdminUserController::class, 'editPassword'])->name('admin.user.editPassword');
        Route::post('/update-password/{id}', [AdminUserController::class, 'updatePassword'])->name('admin.user.updatePassword');
        Route::delete('del/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
    });

    // admin/categories
    Route::prefix('categories')->group(function () {
        Route::get('/list', [AdminCategoriesController::class, 'index'])->name('admin.categories.list');
        Route::get('/add', [AdminCategoriesController::class, 'add'])->name('admin.categories.add');
        Route::post('/add', [AdminCategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/edit/{categories}', [AdminCategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/update/{categories}', [AdminCategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('del/{id}', [AdminCategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    });


    // admin/post
    Route::prefix('post')->group(function () {
        Route::post('ckeditor/upload',  [AdminPostController::class, 'upload'])->name('ckeditor.upload');
        Route::get('/list', [AdminPostController::class, 'index'])->name('admin.post.list');
        Route::get('/add', [AdminPostController::class, 'add'])->name('admin.post.add');
        Route::post('/add', [AdminPostController::class, 'store'])->name('admin.post.store');
        Route::get('/show/{post}', [AdminPostController::class, 'show'])->name('admin.post.show');
        Route::get('/edit/{post}', [AdminPostController::class, 'edit'])->name('admin.post.edit');
        Route::post('/update/{post}', [AdminPostController::class, 'update'])->name('admin.post.update');
        Route::delete('/del/{id}', [AdminPostController::class, 'destroy'])->name('admin.post.destroy');
    });

    // admin/comment
    Route::prefix('comment')->group(function () {
        Route::get('/list', [AdminCommentController::class, 'index'])->name('admin.comment.list');
        Route::get('/active/{comment}', [AdminCommentController::class, 'active'])->name('admin.comment.active');
        Route::get('/active-all/{dataIdActive}', [AdminCommentController::class, 'activeAll'])->name('admin.comment.active-all');
        Route::get('/inactive/{comment}', [AdminCommentController::class, 'inactive'])->name('admin.comment.inactive');
        Route::get('/show/{comment}', [AdminCommentController::class, 'show'])->name('admin.comment.show');
        Route::get('/del/{id}', [AdminCommentController::class, 'destroy'])->name('admin.comment.destroy');
//        Route::get('/edit/{post}', [AdminCommentController::class, 'edit'])->name('admin.comment.edit');
//        Route::post('/update/{post}', [AdminCommentController::class, 'update'])->name('admin.comment.update');
    });

});



// ==================================== client ==================================
// dashboard
Route::get('/', [UserMainController::class, 'index'])->name('dashboard');

// login
Route::get('login', [UserAuthController::class, 'login'])->name('client.login');
Route::post('login', [UserAuthController::class, 'postLogin'])->name('client.login.store');

// logout
Route::get('logout', [UserAuthController::class, 'logout'])->name('client.logout');

// register
Route::get('register', [UserAuthController::class, 'indexRegister'])->name('client.register');
Route::post('register/store', [UserAuthController::class, 'registerStore'])->name('client.register.post');
Route::get('account/verify/{token}', [UserAuthController::class, 'verifyAccount'])->name('client.register.verify');
Route::get('register-success', [UserAuthController::class, 'registerSuccess'])->name('client.register-success');

// forget password
Route::get('forgetPassword', [UserAuthController::class, 'indexForgetPassword'])->name('client.forget-password');
Route::post('forgetPassword', [UserAuthController::class, 'submitForgetPasswordForm'])->name('admin.forget-password.post');
Route::get('forgetPasswordLink/{token}/{email}', [UserAuthController::class, 'showResetPasswordForm'])->name('client.forget-password-link.get');
Route::post('reset-password', [UserAuthController::class, 'submitResetPasswordForm'])->name('client.password.post');
Route::get('changePasswordSuccess', [UserAuthController::class, 'showChangePasswordSuccess'])->name('client.showChangePasswordSuccess');


// client/profile
Route::group(['prefix' => 'client', 'middleware' => ['isUser']], function(){
    Route::get('/profile', [UserProfileController::class, 'profile'])->name('client.profile');
    Route::get('/profile/edit', [UserProfileController::class, 'profileEdit'])->name('client.profile.edit');
    Route::post('/profile/edit', [UserProfileController::class, 'profileUpdate'])->name('client.profile.update');
    Route::get('/profile/edit-password/{id}', [UserProfileController::class, 'editPassword'])->name('client.profile.editPassword');
    Route::post('/profile/edit-password', [UserProfileController::class, 'profileUpdatePassword'])->name('client.profile.updatePassword');
});

// list posts by categories
Route::get("/c/{slugCategory}", [UserMainController::class, 'indexCategory'])->name('client.category.posts');

// detail post
Route::get("/{slugPost}", [UserMainController::class, 'indexPost'])->name('client.post.detail');

// store comment
Route::post('/comment', [UserMainController::class, 'postComment'])->name('client.post.comment');


