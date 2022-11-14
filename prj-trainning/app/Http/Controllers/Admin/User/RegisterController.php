<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.users.register', [
            'title' => 'Dang ky tai khoan'
        ]);
    }

    public function store(StoreRegisterRequest $request)
    {

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
//        $user = User::create([
//            'email' => $input['email'],
//            'first_name' => $input['first_name'],
//            'last_name' => $input['last_name'],
//            'password' => $input['password'],
//            'sex' => $input['sex'],
//            'address' => $input['address'],
//        ]);
        return redirect()->route('admin.login');
    }
}
