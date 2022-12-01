<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\services\Auth\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
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
        return view('admin.users.login', [
            'title' => 'Dang nhap he thong'
        ]);
    }
    public function store(LoginRequest $request)
    {
        $result = $this->authServices->postLoginAdmin($request);
        if ($result)
        {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->withInput($request->input());

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/admin/login');
    }

}
