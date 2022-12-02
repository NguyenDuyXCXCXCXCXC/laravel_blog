<?php

namespace App\Http\services\Auth;

use App\Repositories\AuthRepositories;
use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mail;

class AuthServices
{
    protected $authRepositories;
    protected $userRepositories;
    public function __construct(AuthRepositories $authRepositories, UserRepositories $userRepositories)
    {
        $this->authRepositories = $authRepositories;
        $this->userRepositories = $userRepositories;
    }

    public function postLoginClient($request)
    {
        return $this->authRepositories->postLoginClient($request);
    }

    public function postLoginAdmin($request)
    {
        return $this->authRepositories->postLoginAdmin($request);
    }

    public function postRegister($request)
    {


        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $user = $this->authRepositories->createUser($input);

            $token = Str::random(64);
            $userVertify = $this->authRepositories->createUserVertify($user->id, $token);

            if ($input['role'] == 2){
                Mail::send('emails.emailVerificationEmailClient', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });
            }else{
                Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });
            }


        }catch (\Exception $err){
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function verifyAccount($token)
    {
        try {
            $verifyUser = $this->authRepositories->getUserVerifyByToken($token);
            $message = 'Xin lỗi email của bạn không thể được xác định.';
            if(!is_null($verifyUser) ){
                $user = $verifyUser->user;

                if(!$user->is_email_verified) {
                    $verifyUser->user->is_email_verified = 1;
                    $verifyUser->user->save();
                    $message = "Email của bạn đã được xác minh. Bây giờ bạn có thể đăng nhập.";
                } else {
                    $message = "Email của bạn đã được xác minh trước đó. Bây giờ bạn có thể đăng nhập.";
                }
            }
        }catch (\Exception $err){
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }




    public function submitForgetPasswordForm($request)
    {
        try {
            $token = Str::random(64);
            $email =$request->email;

            $this->authRepositories->createEmailReset($email, $token);

            $user = $this->userRepositories->getUserByEmail($email);

            if ($user->role == 2){
                Mail::send('emails.forgetPasswordClient', ['token' => $token, 'email' => $email], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });
            }else{
                Mail::send('emails.forgetPassword', ['token' => $token, 'email' => $email], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });
            }


        }catch (\Exception $err){
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }



    public function getRecordByEmailToken($token, $email)
    {
        return $this->authRepositories->getRecordByEmailToken($token, $email);
    }

    public function handleResetPassword($request)
    {
        try {
            $password = bcrypt($request->password);
            $this->authRepositories->resetPassword($request->email, $password);
            $this->authRepositories->deleteRecordPasswordResetByEmail($request->email);
            session(['changeSuccess' => 'success']);
        }catch (\Exception $err){
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }



}
