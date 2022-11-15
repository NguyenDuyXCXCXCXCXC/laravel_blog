<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.users.forget-password', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function showResetPasswordForm()
    {
        return view('admin.users.forget-password-link', [
            'title' => 'Giao diện màn hình Nhập mật khẩu mới'
        ]);
    }

    public function showChangePasswordSuccess()
    {
        return view('admin.users.change-password-success', [
            'title' => 'Thay đổi mật khẩu thành công'
        ]);
    }
}
