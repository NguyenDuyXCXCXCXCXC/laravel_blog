<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = '';
        $searchSex = '';
        // search name && sex
        if ($request->input('search') != null && $request->input('sex') != null){

            $search = $request->input('search');
            $searchSex = $request->input('sex');

            $users = User::where('sex', '=', "{$searchSex}")
                ->Where(function($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")
                        ->where('last_name', 'LIKE', "%{$search}%");
                })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search, 'sex' => $searchSex]);

        // search name
        }elseif ($request->input('search') != null){

            $search = $request->input('search');

            $users = User::Where(function($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")
                        ->where('last_name', 'LIKE', "%{$search}%");
                })->orderByDesc('id')->paginate(7);
            $users->appends(['search' => $search]);
        // search sex
        }elseif ($request->input('sex') != null){
            $searchSex = $request->input('sex');

            $users = User::where('sex', '=', "{$searchSex}")
                ->orderByDesc('id')->paginate(7);
            $users->appends([ 'sex' => $searchSex]);
        }else{
            $users = User::orderByDesc('id')->paginate(7);
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
        $emailUserCreater = Auth::user()->email;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $emailUser =  $input['email'];

//        if ($image = $request->file('avatar')) {
//            $destinationPath = 'public/image/';
//            $profileImage = $emailUser . time() . "." . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $profileImage);
//            $input['avatar'] = "$profileImage";
//        }

        if ($image = $request->file('avatar')) {
            $destinationPath = 'image/';
            $profileImage = $emailUserCreater . time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['avatar'] = "$profileImage";
        }
        $user = User::create($input);
        Session::flash('mySuccess', 'Tài khoản ' . $emailUser .' đã được thêm mới' );
        return redirect()->route('admin.user.list');
    }



    public function destroy($id)
    {
        User::find($id)->delete($id);
        Session::flash('mySuccess', 'Xóa thành công!' );
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);

    }
}

