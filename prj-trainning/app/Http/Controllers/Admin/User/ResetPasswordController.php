<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        return view('admin.users.forget-password', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function submitForgetPasswordForm(Request $request)
    {
//        dd($request->input());
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
            'email.required' => 'vui lòng nhập đại chỉ email!',
            'email.exists' => 'Địa chỉ mail không tồn tại!'
            ]
        );


        $token = Str::random(64);
        $email =$request->email;
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token, 'email' => $email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!');

    }

    public function showResetPasswordForm($token, $email)
    {
        return view('admin.users.forget-password-link', [
            'title' => 'Giao diện màn hình Nhập mật khẩu mới',
            'token' => $token,
            'email' => $email
        ]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => ['required', 'max:50', Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()]
        ], [
            'password.required' => 'Mật khẩu không được để trống!',
            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
            'password.letters' => 'Mật khẩu yêu cầu ít nhất một chữ cái!',
            'password.mixedCase' => 'Mật khẩu yêu cầu ít nhất một chữ hoa và một chữ thường!',
            'password.numbers' => 'Mật khẩu yêu cầu ít nhất một số!',
            'password.symbols' => 'Mật khẩu yêu cầu ít nhất một biểu tượng!'
        ]);
//
//        $updatePassword = DB::table('password_resets')
//            ->where([
//                'email' => $request->email,
//                'token' => $request->token
//            ])
//            ->first();
//
//        if(!$updatePassword){
//            return back()->withInput()->with('error', 'Invalid token!');
//        }

        $password = bcrypt($request->password);
        $user = User::where('email', $request->email)
            ->update(['password' => $password]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/admin/changePasswordSuccess');
    }

    public function showChangePasswordSuccess()
    {
        return view('admin.users.change-password-success', [
            'title' => 'Thay đổi mật khẩu thành công'
        ]);
    }
}
