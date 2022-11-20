<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriesRequest extends FormRequest
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
            'categories' =>'required|max:100'
        ];
    }
    public function messages()
    {
        return [
            'categories.required' => 'Categories không được để trống!',
            'categories.max' => 'Categories không vượt quá 100 ký tự!',
        ];
    }
}
