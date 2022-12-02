<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostUpdateRequest extends FormRequest
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
            'title'  =>'required|max:200',
            'categories_id' =>'required',
            'hot_flag' =>'required',
            'content' =>'required',
            'photo'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không vượt quá 200 ký tự!',
            'categories_id.required' => 'Danh mục không được để trống!',
            'hot_flag.required' => 'Trạng thái nổi bật không được để trống!',
            'content.required' => 'Nội dung bài viết không được để trống!',
            'photo.image' => 'Yêu cầu file định dạng phải là ảnh!',
            'photo.max' => 'Yêu cầu kích thước <= 10MB!',
        ];
    }
}
