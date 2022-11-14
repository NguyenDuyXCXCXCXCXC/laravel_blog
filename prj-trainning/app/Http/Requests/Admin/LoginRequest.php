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
            'email.required' => 'A email is required',
            'email.max' => 'A email max:100',
            'email.min' => 'A email min:10',
            'password.required' => 'A password is required',
            'password.max' => 'A email max:50',
        ];
    }
}
