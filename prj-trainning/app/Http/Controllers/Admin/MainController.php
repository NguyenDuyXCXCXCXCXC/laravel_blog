<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.home', [
            'title' => 'Trang quản trị admin',
            'user' => $user
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        return view('admin.users.profile', [
            'title' => 'Trang quản trị admin profile',
            'user' => $user
        ]);
    }

    public function profileEdit()
    {
        $user = Auth::user();

        return view('admin.users.profile-edit', [
            'title' => 'Trang chỉnh sửa profile',
            'user' => $user
        ]);
    }

    public function profileUpdate(Request $request)
    {

        $request->validate([
            'email' => 'required|max:100|min:12|email:filter',
//            'password' => 'required|confirmed|min:10|max:50|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'first_name' => 'required|max:50',
            'last_name'=> 'required|max:50',
            'avatar'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'email.required' => 'Email không được để trống!',
            'email.max' => 'Địa chỉ mail không vượt quá 100 ký tự!',
            'email.min' => 'Địa chỉ mail không được ít hơn 12 ký tự!',
//            'password.required' => 'Mật khẩu không được để trống!',
//            'password.confirmed' => 'Mật khẩu comfirm chưa khớp với mật khẩu!!',
//            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
//            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
//            'password.regex' => 'Mật khẩu có ít nhất 1 chữ cái viết hoa, 1 chữ cái thường, 1 số, 1 ký tự đặc biệt!',
            'first_name.required' => 'Trường họ không được để trống!',
            'first_name.max' => 'Trường họ không vượt quá 50 ký tự!',
            'last_name.required' => 'Trường tên không được để trống!',
            'last_name.max' => 'Trường tên không vượt quá 50 ký tự!',
            'sex.required' => 'Trường giới tính không được để trống!',
            'role.required' => 'Trường vai trò không được để trống!',
            'avatar.required' => 'Trường avatar không được để trống!',
            'avatar.image' => 'Yêu cầu file định dạng phải là ảnh!',
            'avatar.max' => 'Yêu cầu kích thước <= 10MB!',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $idUserCreater = Auth::user()->id;
        $input = $request->all();
        $emailUser =  $input['email'];

        if ($image = $request->file('avatar')) {
            $destinationPath = 'image/';
            $profileImage = $idUserCreater . time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['avatar'] = "$profileImage";
        }else{
            unset($input['avatar']);
        }


        $user->update($input);
        Session::flash('mySuccess', 'Tài khoản ' . $emailUser .' đã được chỉnh sửa' );
        return redirect()->route('admin.profile');
    }


    public function editPassword($id)
    {
        $user = Auth::user();
        return view('admin.users.profile-edit-password', [
            'title' => 'Trang chỉnh sửa Password Profile',
            'user' => $user,
            'id' => $id
        ]);
    }

    public function profileUpdatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:10|max:50|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ], [
            'password.required' => 'Mật khẩu không được để trống!',
            'password.confirmed' => 'Mật khẩu comfirm chưa khớp với mật khẩu!!',
            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
            'password.regex' => 'Mật khẩu có ít nhất 1 chữ cái viết hoa, 1 chữ cái thường, 1 số, 1 ký tự đặc biệt!',
        ]);

        $user = User::where('id', $request->input('id_user_changepass'))->first();
        $input = $request->all();
        $input['password_old'] = bcrypt($input['password_old']);
        if(Auth::attempt([
            'email' => $user->email,
            'password' => $request->input('password_old'),
        ])){
            $input['password'] = bcrypt($input['password']);
            $user->update(['password' => $input['password']]);
            Session::flash('mySuccess', 'Đổi mật khẩu thành công!');
            return redirect()->route('admin.profile.edit');
        }
        Session::flash('myError', 'Mật khẩu cũ chưa chính xác!');
        return redirect()->back();
    }


}
