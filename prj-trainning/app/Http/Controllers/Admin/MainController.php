<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserUpdatePassRequest;
use App\Http\Requests\Admin\StoreUserUpdateRequest;
use App\Http\services\User\UserServices;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{

    protected $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.home', [
            'title' => 'Trang quản trị admin',
            'user' => $user
        ]);
    }

    public function profile()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.users.profile', [
            'title' => 'Trang quản trị admin profile',
            'user' => $user
        ]);
    }

    public function profileEdit()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.users.profile-edit', [
            'title' => 'Trang chỉnh sửa profile',
            'user' => $user
        ]);
    }

    public function profileUpdate(StoreUserUpdateRequest $request)
    {
        $result = $this->userServices->updateInfor($request, Auth::guard('admin')->user());
        if ($result){
            return redirect()->route('admin.profile');
        }
    }


    public function editPassword($id)
    {
        $user = Auth::guard('admin')->user();
        return view('admin.users.profile-edit-password', [
            'title' => 'Trang chỉnh sửa Password Profile',
            'user' => $user,
            'id' => $id
        ]);
    }

    public function profileUpdatePassword(StoreUserUpdatePassRequest $request)
    {
        $result = $this->userServices->updatePasswordProfile($request, auth()->guard('admin'));
        if ($result){
            return redirect()->route('admin.profile.edit');
        }
        Session::flash('myError', 'Mật khẩu cũ chưa chính xác!');
        return redirect()->back();
    }


}
