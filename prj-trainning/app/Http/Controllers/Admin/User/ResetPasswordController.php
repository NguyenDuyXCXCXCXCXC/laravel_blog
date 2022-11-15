<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.users.forget-password', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
            'email.required' => 'vui lòng nhập đại chỉ email!',
            'email.exists' => 'Địa chỉ mail không tồn tại!'
            ]
        );
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
