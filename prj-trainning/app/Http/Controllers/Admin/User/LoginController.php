<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.users.login', [
            'title' => 'Dang nhap he thong'
        ]);
    }
    public function store(LoginRequest $request)
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => [1,3]
            ], $request->input('remember')))
        {
            Session::flash('mySuccess', 'Đăng nhập thành công!');
            return redirect()->route('admin.dashboard');
        }else{
            Session::flash('myError', 'Thông tin đăng nhập không chính xác !');
            return redirect()->back()->withInput($request->input());
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/admin/login');
    }

}
