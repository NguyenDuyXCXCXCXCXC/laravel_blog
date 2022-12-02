<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\StoreRegisterRequest;
use App\Http\services\Auth\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authServices;
    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function login()
    {
        return view('auth.login', [
            'title' => 'Dang nhap he thong',
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
        $result = $this->authServices->postLoginClient($request);
        if($result){
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->withInput($request->input());
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect()->route('dashboard');
    }

    public function indexRegister()
    {
        return view('auth.register', [
            'title' => 'Đăng ký tài khoản'
        ]);
    }

    public function registerStore(StoreRegisterRequest $request)
    {

        $result = $this->authServices->postRegister($request);
        if ($result)
        {
            return redirect()->route('client.register-success');
        }
    }



    public function verifyAccount($token)
    {
        $result = $this->authServices->verifyAccount($token);
        if ($result)
        {
            return redirect()->route('client.login');
        }

    }

    public function registerSuccess()
    {
        return view('auth.register-success', [
            'title' => 'Đăng ký tài khoản thành công'
        ]);
    }



}
