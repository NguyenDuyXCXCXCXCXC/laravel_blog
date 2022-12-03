<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreUserUpdatePassRequest;
use App\Http\Requests\Admin\StoreUserUpdateRequest;
use App\Http\services\categories\CategoriesServices;
use App\Http\services\User\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected $categoriesServices;
    private $userServices;

    public function __construct(CategoriesServices $categoriesServices, UserServices $userServices)
    {
        $this->categoriesServices = $categoriesServices;
        $this->userServices = $userServices;
    }

    public function profile()
    {
        $user = Auth::user();

        $categories =  $this->categoriesServices->getAllCategories();
        return view('profile.profile', [
            'title' => 'Trang quản trị profile',
            'categories' => $categories,
            'user' => $user,
            'search' => ''
        ]);
    }

    public function profileEdit()
    {
        $user = Auth::user();
        $categories =  $this->categoriesServices->getAllCategories();

        return view('profile.profile-edit', [
            'title' => 'Trang chỉnh sửa profile',
            'categories' => $categories,
            'user' => $user,
            'search' => '',
        ]);
    }

    public function profileUpdate(StoreUserUpdateRequest $request)
    {
        $result = $this->userServices->updateInfor($request);
        if ($result){
            return redirect()->route('client.profile');
        }
    }


    public function editPassword($id)
    {
        $user = Auth::user();
        $categories =  $this->categoriesServices->getAllCategories();
        return view('profile.profile-edit-password', [
            'title' => 'Trang chỉnh sửa Password Profile',
            'categories' => $categories,
            'user' => $user,
            'search' => '',
            'id' => $id
        ]);
    }


    public function profileUpdatePassword(StoreUserUpdatePassRequest $request)
    {
        $result = $this->userServices->updatePasswordProfile($request);

        if ($result){
            return redirect()->route('client.profile.edit');
        }
        Session::flash('myError', 'Mật khẩu cũ chưa chính xác!');
        return redirect()->back();
    }
}
