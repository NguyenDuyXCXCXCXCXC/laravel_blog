<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
//        if(!Auth::check()){
//            return redirect()->route('admin.login');
//        }
        return 'Dang nhap thanh cong!';
    }
}
