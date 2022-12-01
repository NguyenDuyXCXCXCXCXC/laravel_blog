<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthRepositories
{
    protected $user;
    protected $userVerify;
    public function __construct(User $user, UserVerify $userVerify)
    {
        $this->user = $user;
        $this->userVerify = $userVerify;
    }

    public function postLoginClient($request)
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'is_email_verified' => 1,
            ], $request->input('remember')))
        {
            Session::flash('mySuccess', 'Đăng nhập thành công!');
            return true;
        }else{
            Session::flash('myError', 'Thông tin đăng nhập không chính xác !');
            return false;
        }
    }


    public function postLoginAdmin($request)
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => [1,3],
                'is_email_verified' => 1
            ], $request->input('remember')))
        {
            Session::flash('mySuccess', 'Đăng nhập thành công!');
            return true;
        }else{
            Session::flash('myError', 'Thông tin đăng nhập không chính xác !');
            return false;
        }
    }


    public function createUser($input)
    {
        return $this->user->create($input);
    }

    public function createUserVertify($user_id, $token)
    {
        return $this->userVerify->create([
            'user_id' => $user_id,
            'token' => $token
        ]);
    }


    public function getUserVerifyByToken($token)
    {
        return $this->userVerify->where('token', $token)->first();
    }


    public function createEmailReset($email, $token)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
    }


    public function getRecordByEmailToken($token, $email)
    {
            $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $email,
                'token' => $token
            ])->first();

            return $updatePassword;
    }


    public function resetPassword($email, $password)
    {
        return $this->user->where('email', $email)
            ->update(['password' => $password]);
    }


    public function deleteRecordPasswordResetByEmail($email)
    {
        return DB::table('password_resets')->where(['email'=> $email])->delete();
    }

}
