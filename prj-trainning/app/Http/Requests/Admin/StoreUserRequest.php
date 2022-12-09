<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users|max:100|min:12|email:filter',
            'password' => 'required|confirmed|min:10|max:50|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'first_name' => 'required|max:50',
            'last_name'=> 'required|max:50',
            'sex'=> 'required|integer|min:0|max:2',
            'role'=> 'required|integer|min:1|max:3',
            'birthday'=> 'date',
            'avatar'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',

        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống!',
            'email.max' => 'Địa chỉ mail không vượt quá 100 ký tự!',
            'email.min' => 'Địa chỉ mail không được ít hơn 12 ký tự!',
            'email.unique' => 'Địa chỉ mail đã tồn tại!',
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
        ];
    }
}
