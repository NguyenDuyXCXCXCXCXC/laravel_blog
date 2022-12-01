<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRegisterRequest;
use App\Http\services\Auth\AuthServices;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Str;
use Mail;

class RegisterController extends Controller
{
    protected $authServices;
    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function index()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.users.register', [
            'title' => 'Dang ky tai khoan'
        ]);
    }

    public function store(StoreRegisterRequest $request)
    {
        $result = $this->authServices->postRegister($request);
        if ($result)
        {
            return redirect()->route('admin.register-succes');
        }
    }


    public function registerSuccess()
    {
        return view('admin.users.register-success', [
            'title' => 'Đăng ký tài khoản thành công'
        ]);
    }

    public function verifyAccount($token)
    {
        $result = $this->authServices->verifyAccount($token);
        if ($result)
        {
            return redirect()->route('admin.login');
        }

    }


}
