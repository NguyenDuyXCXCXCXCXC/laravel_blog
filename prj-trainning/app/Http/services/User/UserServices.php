<?php

namespace App\Http\services\User;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserServices
{

    protected $userRepositories;
    public function __construct(UserRepositories $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function getListAdminManagerByParams($request)
    {
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }

        // param search
        $searchMailName = $request->input('search');
        $searchSex = $request->input('sex');
        $searchRequest = [$searchMailName, $searchSex];

        // get users
        $users = $this->userRepositories->getListAdminManagerByParams($searchRequest, $selected_option);

        return [$users, $selected_option, $searchMailName, $searchSex];
    }

    public function getListUser($request)
    {
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }

        // param search
        $searchMailName = $request->input('search');
        $searchSex = $request->input('sex');

        // get users
        $users = $this->userRepositories->getListUser($searchMailName, $searchSex, $selected_option);

        return [$users, $selected_option, $searchMailName, $searchSex];
    }

    public function create($request)
    {
        try {
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
            $result =  $this->userRepositories->create($input);
            Session::flash('mySuccess', 'Tài khoản ' . $emailUser .' đã được thêm mới' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function getUserById($id)
    {
        return $this->userRepositories->getUserById($id);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepositories->getUserByEmail($email);
    }


    public function updateInfor($request)
    {
        try {
            $userEdit = $this->userRepositories->getUserByEmail($request->input('email'));
            $idUserCreater = Auth::user()->id;
            $input = $request->all();
            $emailUser =  $input['email'];

            if ($image = $request->file('avatar')) {
                $destinationPath = 'image/';
                $profileImage = $idUserCreater . time() . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['avatar'] = "$profileImage";
            }else{
                unset($input['avatar']);
            }
            $this->userRepositories->updateInfor($userEdit, $input);
            Session::flash('mySuccess', 'Tài khoản ' . $emailUser .' đã được chỉnh sửa' );
        }catch (\Exception $exception){
            Session::flash('myError', $exception->getMessage() );
            return false;
        }
        return true;
    }

    public function updatePassword($request, $id)
    {
        try {
            $userEdit = $this->getUserById($id);

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $this->userRepositories->updatePassword($input, $userEdit);
            Session::flash('mySuccess', 'Đổi mật khẩu thành công!');
        }catch (\Exception $exception){
            Session::flash('myError', $exception->getMessage() );
            return false;
        }
        return true;
    }

    public function updatePasswordProfile($request)
    {
        try {
            $input = $request->all();
            $userEdit = $this->getUserById($input['id_user_changepass']);
            if(Auth::attempt([
                'email' => $userEdit->email,
                'password' => $request->input('password_old'),
            ]))
            {
                $input['password'] = bcrypt($input['password']);
                $this->userRepositories->updatePassword($input, $userEdit);
                Session::flash('mySuccess', 'Đổi mật khẩu thành công!');
            }else{
                return false;
            }
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($id)
    {
        try {
            $userEdit = $this->userRepositories->getUserById($id);
            $this->userRepositories->destroy($id);
            Session::flash('mySuccess', 'Tài khoản ' . $userEdit->email .' đã được xóa' );
        }catch (\Exception $exception){
            Session::flash('myError', $exception->getMessage() );
            return false;
        }
        return true;
    }

}
