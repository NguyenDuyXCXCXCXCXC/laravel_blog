<?php

namespace App\Http\services\categories;

use App\Models\Categories;

class CategoriesServices
{
    public function getAll($request)
    {
        $search = $request->input('search');
        if($search != null)
        {
            $categories = Categories::where('name', 'LIKE', "%{$search}%")
            ->orderByDesc('id')->paginate(7);
        }else{
            $categories = Categories::orderByDesc('id')->paginate(7);
        }
        return $categories;
    }
}
