<?php

namespace App\Http\services\categories;

use App\Models\Categories;
use Illuminate\Support\Facades\Session;

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

    public function  create($request)
    {
        $input = $request->all();
        try {
            $inputCate = $input['categories'];
            Categories::create([
                'name' => $input['categories']
            ]);
            Session::flash('mySuccess', 'Danh mục ' . $inputCate .' đã được thêm mới' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function update($request, $categories)
    {
        $categories->name = $request->input('categories');
        $categories->save();
        return true;
    }



    public function destroy($id)
    {
        return Categories::find($id)->delete($id);
    }
}
