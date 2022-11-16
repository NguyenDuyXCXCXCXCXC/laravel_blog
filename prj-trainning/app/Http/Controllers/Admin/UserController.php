<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(7)    ;
        $user = Auth::user();
        return view('admin.crud-user.list', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'users' => $users
        ]) ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
