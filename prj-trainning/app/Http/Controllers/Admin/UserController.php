<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
    //get: admin/user/list -> list admin & manage
    public function index(Request $request)
    {
        $search = '';
        $searchSex = '';
        // search email, name && sex
        if ($request->input('search') != null && $request->input('sex') != null){

            $search = $request->input('search');
            $searchSex = $request->input('sex');

            $users = User::Where(function($query)  {
                $query->orwhere('role', '=', 1)
                    ->orwhere('role', '=', 3);
            })->where('sex', '=', "{$searchSex}")
                ->Where(function($query) use ($search) {
                    $query->orwhere('last_name', 'LIKE', "%{$search}%")
                        ->orwhere('first_name', 'LIKE', "%{$search}%")
                        ->orwhere('email', 'LIKE', "%{$search}%");
                })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search, 'sex' => $searchSex]);

        // search email, name
        }elseif ($request->input('search') != null){

            $search = $request->input('search');

            $users = User::Where(function($query)  {
                $query->orwhere('role', '=', 1)
                    ->orwhere('role', '=', 3);
            })->Where(function($query) use ($search) {
                    $query->orwhere('first_name', 'LIKE', "%{$search}%")
                        ->orwhere('last_name', 'LIKE', "%{$search}%")
                        ->orwhere('email', 'LIKE', "%{$search}%");
                })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search]);
        // search sex
        }elseif ($request->input('sex') != null){
            $searchSex = $request->input('sex');

            $users = User::Where(function($query)  {
                $query->orwhere('role', '=', 1)
                    ->orwhere('role', '=', 3);
            })->where('sex', '=', "{$searchSex}")
                ->orderByDesc('id')->paginate(7);
            $users->appends([ 'sex' => $searchSex]);
        }else{
            $users = User::Where(function($query)  {
                $query->orwhere('role', '=', 1)
                    ->orwhere('role', '=', 3);
            })->orderByDesc('id')->paginate(7);
//            $users = User::orderByDesc('id')->simplePaginate(4);
        }


        $user = Auth::user();

        return view('admin.crud-user.list', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'users' => $users
        ]) ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function indexForUser(Request $request)
    {
        $search = '';
        $searchSex = '';
        // search email, name && sex
        if ($request->input('search') != null && $request->input('sex') != null){

            $search = $request->input('search');
            $searchSex = $request->input('sex');

            $users = User::where('role', '=', 2)
                ->where('sex', '=', "{$searchSex}")
                ->Where(function($query) use ($search) {
                    $query->orwhere('last_name', 'LIKE', "%{$search}%")
                        ->orwhere('first_name', 'LIKE', "%{$search}%")
                        ->orwhere('email', 'LIKE', "%{$search}%");
                })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search, 'sex' => $searchSex]);

            // search email, name
        }elseif ($request->input('search') != null){

            $search = $request->input('search');

            $users = User::where('role', '=', 2)
                ->Where(function($query) use ($search) {
                $query->orwhere('first_name', 'LIKE', "%{$search}%")
                    ->orwhere('last_name', 'LIKE', "%{$search}%")
                    ->orwhere('email', 'LIKE', "%{$search}%");
            })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search]);
            // search sex
        }elseif ($request->input('sex') != null){
            $searchSex = $request->input('sex');

            $users = User::where('role', '=', 2)
                ->where('sex', '=', "{$searchSex}")
                ->orderByDesc('id')->paginate(7);
            $users->appends([ 'sex' => $searchSex]);
        }else{
            $users = User::where('role', '=', "2")
                ->orderByDesc('id')->paginate(7);
//            $users = User::orderByDesc('id')->simplePaginate(4);
        }


        $user = Auth::user();

        return view('admin.crud-user.list', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'users' => $users
        ]) ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function add()
    {
        $user = Auth::user();
        return view('admin.crud-user.add', [
            'title' => 'Thêm mới user',
            'user' => $user,
        ]);
    }


    public function store(StoreUserRequest $request)
    {
        $idUserCreater = Auth::user()->id;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $emailUser =  $input['email'];

        if ($image = $request->file('avatar')) {
            $destinationPath = 'image/';
            $profileImage = $idUserCreater . time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['avatar'] = "$profileImage";
        }
        $user = User::create($input);
        Session::flash('mySuccess', 'Tài khoản ' . $emailUser .' đã được thêm mới' );
        return redirect()->route('admin.user.list');
    }


    public function edit($id)
    {
        $userEdit = User::where('id', $id)->first();
        if($userEdit==null){
            return redirect()->route('admin.user.list');
        }
        $user = Auth::user();
        return view('admin.crud-user.edit', [
            'title' => 'Sửa user: '.$userEdit->first_name.' '.$userEdit->last_name,
            'user' => $user,
            'userEdit' =>$userEdit
        ]);
    }

    public function update(Request $request)
    {

        $request->validate([
            'email' => 'required|max:100|min:12|email:filter',
            'password' => 'required|confirmed|min:10|max:50|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'first_name' => 'required|max:50',
            'last_name'=> 'required|max:50',
            'avatar'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'email.required' => 'Email không được để trống!',
            'email.max' => 'Địa chỉ mail không vượt quá 100 ký tự!',
            'email.min' => 'Địa chỉ mail không được ít hơn 12 ký tự!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.confirmed' => 'Mật khẩu comfirm chưa khớp với mật khẩu!!',
            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
            'password.regex' => 'Mật khẩu có ít nhất 1 chữ cái viết hoa, 1 chữ cái thường, 1 số, 1 ký tự đặc biệt!',
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
        $input['password'] = bcrypt($input['password']);
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
        return redirect()->route('admin.user.list');
    }

    public function destroy($id)
    {
        User::find($id)->delete($id);
//        Session::flash('mySuccess', 'Xóa thành công!' );
        return response()->json([
            'message' => 'Record deleted successfully!'
        ]);

    }
}

