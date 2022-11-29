<?php

namespace App\Http\services\categories;

use App\Models\Categories;
use App\Repositories\CategoriesRepository;
use Illuminate\Support\Facades\Session;

class CategoriesServices
{
    protected $categoriesRepository;
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getAll($request)
    {
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }
//        dd($selected_option);
        $search = $request->input('search');
        if($search != null)
        {
            $categories = Categories::where('name', 'LIKE', "%{$search}%")
            ->orderByDesc('id')->paginate($selected_option);
        }else{
            $categories = Categories::orderByDesc('id')->paginate($selected_option);
        }
        return [$categories, $selected_option];
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



//    ==== for client ===
    public function getAllCategories()
    {
        return $this->categoriesRepository->getAllCategories();

    }
}
