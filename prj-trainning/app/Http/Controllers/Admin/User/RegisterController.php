<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRegisterRequest;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Str;
use Mail;

class RegisterController extends Controller
{
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
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
//        $user = User::create([
//            'email' => $input['email'],
//            'first_name' => $input['first_name'],
//            'last_name' => $input['last_name'],
//            'password' => $input['password'],
//            'sex' => $input['sex'],
//            'address' => $input['address'],
//        ]);

        $token = Str::random(64);

        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });

        return redirect()->route('admin.register-succes');
    }




    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

//        return redirect()->route('admin.login')->with('message', $message);
        return redirect()->route('admin.login');
    }

    public function registerSuccess()
    {
        return view('admin.users.register-success', [
            'title' => 'Đăng ký tài khoản thành công'
        ]);
    }
}
