<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthRepositories
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function postLoginClient($request)
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ], $request->input('remember')))
        {
            Session::flash('mySuccess', 'Đăng nhập thành công!');
            return true;
        }else{
            Session::flash('myError', 'Thông tin đăng nhập không chính xác !');
            return false;
        }
    }
}
