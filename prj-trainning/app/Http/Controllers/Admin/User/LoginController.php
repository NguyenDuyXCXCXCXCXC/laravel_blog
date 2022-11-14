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
        return view('admin.users.login', [
            'title' => 'Dang nhap he thong'
        ]);
    }
    public function store(LoginRequest $request)
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], $request->input('remember')))
        {
            return redirect()->route('admin');
        }else{
            Session::flash('error', 'Email hoac Password khong dung');
            return redirect()->back()->withInput($request->input());
        }
    }


}
