<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class StoreRegisterRequest extends FormRequest
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
            'email' => 'required|unique:users|max:100|min:10|email:filter',
            'password' => ['required', 'max:50', Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'first_name' => 'required|max:50',
            'last_name'=> 'required|max:50',
            'address' => 'required'
        ];
    }
}
