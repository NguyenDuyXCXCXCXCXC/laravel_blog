<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.users.forgot-password', [
            'title' => 'Quen mat khau'
        ]);
    }
}
