<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
            'email' => 'required|max:100|min:10|email:filter',
            'password' => ['required', 'max:50', Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống!',
            'email.max' => 'Địa chỉ mail không vượt quá 100 ký tự!',
            'email.min' => 'Địa chỉ mail không được ít hơn 10 ký tự!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.max' => 'Mật khẩu không vượt quá 50 ký tự!',
            'password.min' => 'Mật khẩu không được ít hơn 10 ký tự!',
            'password.letters' => 'Mật khẩu yêu cầu ít nhất một chữ cái!',
            'password.mixedCase' => 'Mật khẩu yêu cầu ít nhất một chữ hoa và một chữ thường!',
            'password.numbers' => 'Mật khẩu yêu cầu ít nhất một số!',
            'password.symbols' => 'Mật khẩu yêu cầu ít nhất một biểu tượng!',
        ];
    }
}
