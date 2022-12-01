<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserUpdatePassRequest extends FormRequest
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
            'password' => 'required|confirmed|min:10|max:50|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu không được để trống!',
            'password.confirmed' => 'Mật khẩu comfirm chưa khớp với mật khẩu!!',
            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
            'password.regex' => 'Mật khẩu có ít nhất 1 chữ cái viết hoa, 1 chữ cái thường, 1 số, 1 ký tự đặc biệt!',
        ];
    }
}
