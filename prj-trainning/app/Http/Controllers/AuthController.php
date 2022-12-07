<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\StoreRegisterRequest;
use App\Http\Requests\Admin\StoreUserUpdatePassRequest;
use App\Http\services\Auth\AuthServices;
use App\Http\services\categories\CategoriesServices;
use App\Http\services\post\PostServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authServices;
    protected $postServices;
    protected $categoriesServices;
    public function __construct(AuthServices $authServices, PostServices $postServices, CategoriesServices $categoriesServices)
    {
        $this->authServices = $authServices;
        $this->postServices = $postServices;
        $this->categoriesServices = $categoriesServices;
    }

    public function login(Request $request)
    {
        if ($request->slug_post != null){
            $slug_post = $request->slug_post;
        }else{
            $slug_post = '';
        }
        return view('auth.login', [
            'title' => 'Dang nhap he thong',
            'slug_post' => $slug_post
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
//        login thong thuong
        if ($request->slug_post == null){
            $result = $this->authServices->postLoginClient($request);
            if($result){
                return redirect()->route('dashboard');
            }else{
                return redirect()->back()->withInput($request->input());
            }
        }else{ // login cho phan comment
            $result = $this->authServices->postLoginClient($request);

            if($result){
                $post = $this->postServices->getPostBySlug($request->slug_post);
                if (empty($post))
                {
                    return redirect()->back();
                }
                $title = $post->title;
                $categories =  $this->categoriesServices->getAllCategories();
                $idCategoryByPost = $post->category_id;
                $idPost = $post->id;
//                $postRandom = $this->postsServices->getPostsByIdCategoryRandom($request, $idCategoryByPost, $idPost);
                $postRandom = $this->postServices->getPostsByIdCategoryRandom($request, $idCategoryByPost, $idPost);
                return view('post', [
                    'title' => $title,
                    'categories' => $categories,
                    'post' => $post,
                    'postRandom' => $postRandom,
                    'search' => $request->search
                ]);
            }else{
                return redirect()->back()->withInput($request->input());
            }
        }

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect()->route('dashboard');
    }

    public function indexRegister()
    {
        return view('auth.register', [
            'title' => 'Đăng ký tài khoản'
        ]);
    }

    public function registerStore(StoreRegisterRequest $request)
    {

        $result = $this->authServices->postRegister($request);
        if ($result)
        {
            return redirect()->route('client.register-success');
        }
    }



    public function verifyAccount($token)
    {
        $result = $this->authServices->verifyAccount($token);
        if ($result)
        {
            return redirect()->route('client.login');
        }

    }

    public function registerSuccess()
    {
        return view('auth.register-success', [
            'title' => 'Đăng ký tài khoản thành công'
        ]);
    }

    public function indexForgetPassword()
    {
        return view('auth.forget-password', [
            'title' => 'Quên mật khẩu'
        ]);
    }


    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
                'email.required' => 'vui lòng nhập đại chỉ email!',
                'email.exists' => 'Địa chỉ mail không tồn tại!'
            ]
        );

        $result = $this->authServices->submitForgetPasswordForm($request);

        return back()->with('message', 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!');

    }



    public function showResetPasswordForm($token, $email)
    {
        // check xem da doi pass chua: neu doi roi -> 404
        $updatePassword = $this->authServices->getRecordByEmailToken($token, $email);
        if(!$updatePassword ){
            return abort(404);;
        }
        // end check xem da doi pass chua


        // check time forgot: neu qua 10p se ko doi dc
        $time_forgot = $updatePassword->created_at;
        $time_forgot = strtotime($time_forgot);

        $now = date('Y-m-d H:i:s');
        $now = strtotime($now);

        $checkTimeForgot = $now-$time_forgot;
        if($checkTimeForgot > 600 ){
            return abort(404);
        }

        // end check time forgot



        return view('auth.forget-password-link', [
            'title' => 'Giao diện màn hình Nhập mật khẩu mới',
            'token' => $token,
            'email' => $email
        ]);
    }

    public function submitResetPasswordForm(StoreUserUpdatePassRequest $request)
    {
        $updatePassword = $this->authServices->getRecordByEmailToken($request->token, $request->email);


        if(!$updatePassword){
            return back()->withInput()->with('myError', 'Invalid token!');
        }

        $result = $this->authServices->handleResetPassword($request);

        return redirect()->route('client.showChangePasswordSuccess');
    }

    public function showChangePasswordSuccess()
    {
        $value = \Illuminate\Support\Facades\Session::get('changeSuccess');
        if ($value == null || $value == '')
        {
            return abort(404);
        }
        \Illuminate\Support\Facades\Session::forget('changeSuccess');

        return view('auth.change-password-success', [
            'title' => 'Thay đổi mật khẩu thành công'
        ]);
    }



}
