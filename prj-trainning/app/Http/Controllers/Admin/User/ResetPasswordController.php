<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserUpdatePassRequest;
use App\Http\services\Auth\AuthServices;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    protected $authServices;
    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function index()
    {
        return view('admin.users.forget-password', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
            'email.required' => 'vui lòng nhập đại chỉ email!',
            'email.exists' => 'Địa chỉ mail không tồn tại!'
            ]
        );

        $result = $this->authServices->submitForgetPasswordForm($request);

        return back()->with('message', 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!');

    }

    public function showResetPasswordForm($token, $email)
    {
        // check xem da doi pass chua: neu doi roi -> 404
        $updatePassword = $this->authServices->getRecordByEmailToken($token, $email);
        if(!$updatePassword ){
            return abort(404);;
        }
        // end check xem da doi pass chua


        // check time forgot: neu qua 10p se ko doi dc
        $time_forgot = $updatePassword->created_at;
        $time_forgot = strtotime($time_forgot);

        $now = date('Y-m-d H:i:s');
        $now = strtotime($now);

        $checkTimeForgot = $now-$time_forgot;
        if($checkTimeForgot > 600 ){
            return abort(404);
        }

        // end check time forgot



        return view('admin.users.forget-password-link', [
            'title' => 'Giao diện màn hình Nhập mật khẩu mới',
            'token' => $token,
            'email' => $email
        ]);
    }

    public function submitResetPasswordForm(StoreUserUpdatePassRequest $request)
    {
        $updatePassword = $this->authServices->getRecordByEmailToken($request->token, $request->email);


        if(!$updatePassword){
            return back()->withInput()->with('myError', 'Invalid token!');
        }

        $result = $this->authServices->handleResetPassword($request);

        return redirect('/admin/changePasswordSuccess');
    }

    public function showChangePasswordSuccess()
    {
        $value = \Illuminate\Support\Facades\Session::get('changeSuccess');
        if ($value == null || $value == '')
        {
            return abort(404);
        }
        \Illuminate\Support\Facades\Session::forget('changeSuccess');

        return view('admin.users.change-password-success', [
            'title' => 'Thay đổi mật khẩu thành công'
        ]);
    }
}
