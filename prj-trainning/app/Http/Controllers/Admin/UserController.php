<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\StoreUserUpdatePassRequest;
use App\Http\Requests\Admin\StoreUserUpdateRequest;
use App\Http\services\User\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{

    protected $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    //get: admin/user/list -> list admin & manager
    public function index(Request $request)
    {
        // check role, chi manager ms vao dc list admin & manager
        if(Auth::guard('admin')->user()->role != 3)
        {
            return redirect()->route('admin.user.listForUser');
        }
        $result = $this->userServices->getListAdminManagerByParams($request);
        $users = $result[0];
        $selected_option = $result[1];
        $search = $result[2];
        $sex = $result[3];

        $user = Auth::guard('admin')->user();

        return view('admin.crud-user.list', [
            'title' => 'Trang quản trị danh sách admin',
            'user' => $user,
            'users' => $users,
            'search' => $search,
            'sex' => $sex,
        ]) ->with('i', (request()->input('page', 1) - 1) * $selected_option);
    }

    //get: admin/user/listUser -> list user
    public function indexForUser(Request $request)
    {
        $result = $this->userServices->getListUser($request);
        $users = $result[0];
        $selected_option = $result[1];
        $search = $result[2];
        $sex = $result[3];

        $user = Auth::guard('admin')->user();

        return view('admin.crud-user.list', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'users' => $users,
            'search' => $search,
            'sex' => $sex,
        ]) ->with('i', (request()->input('page', 1) - 1) * $selected_option);
    }


    public function add()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.crud-user.add', [
            'title' => 'Thêm mới user',
            'user' => $user,
        ]);
    }


    public function store(StoreUserRequest $request)
    {
        if (Auth::guard('admin')->user()->role == 1){
            return redirect()->route('admin.user.listForUser');
        }
        $this->userServices->create($request);
        if ($request->input('role') == 2){
            return redirect()->route('admin.user.listForUser');
        }
        return redirect()->route('admin.list');
    }


    public function edit($id)
    {
        $userEdit = $this->userServices->getUserById($id);
        if($userEdit==null){
            return redirect()->route('admin.list');
        }
        $user = Auth::guard('admin')->user();
        return view('admin.crud-user.edit', [
            'title' => 'Sửa user: '.$userEdit->first_name.' '.$userEdit->last_name,
            'user' => $user,
            'userEdit' =>$userEdit
        ]);
    }

    public function update(StoreUserUpdateRequest $request)
    {
        if (Auth::guard('admin')->user()->role == 1){
            return redirect()->route('admin.user.listForUser');
        }

        $userEdit = $this->userServices->getUserByEmail($request->input('email'));

        $result = $this->userServices->updateInfor($request, Auth::guard('admin')->user());
        if ($result)
        {
            if ($userEdit->role == 1){
                return redirect()->route('admin.list');
            }
            return redirect()->route('admin.user.listForUser');
        }
    }

    public function editPassword($id)
    {
        $userEdit = $this->userServices->getUserById($id);
        $user = Auth::guard('admin')->user();
        return view('admin.crud-user.edit-password', [
            'title' => 'Sửa password user: '.$userEdit->first_name.' '.$userEdit->last_name,
            'user' => $user,
            'userEdit' =>$userEdit
        ]);
    }

    public function updatePassword(StoreUserUpdatePassRequest $request, $id)
    {
        $result = $this->userServices->updatePassword($request, $id);
        if ($result)
        {
            return redirect()->route('admin.user.edit', $id);
        }

    }




    public function destroy($id)
    {
        $result = $this->userServices->destroy($id);
        if ($result){
            return redirect()->back();
        }
    }
}

