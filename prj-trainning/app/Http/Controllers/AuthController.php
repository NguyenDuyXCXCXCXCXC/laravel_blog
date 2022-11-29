<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\services\Auth\AuthServices;
use Illuminate\Http\Request;

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

}
