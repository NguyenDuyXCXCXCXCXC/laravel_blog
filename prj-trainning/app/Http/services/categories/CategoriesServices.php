<?php

namespace App\Http\services\categories;

use App\Models\Categories;
use App\Repositories\CategoriesRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoriesServices
{
    protected $categoriesRepository;
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getCategoriesByParams($request)
    {
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }
        $search = $request->input('search');
//        get: $categories && $selected_option
        $categories =  $this->categoriesRepository->getCategoriesByParams($search, $selected_option);
        return [$categories, $selected_option, $search];
    }

    public function  createCategory($request)
    {
        $input = $request->all();
        try {
            $inputCate = $input['categories'];
            $this->categoriesRepository->create($input);
            Session::flash('mySuccess', 'Danh mục ' . $inputCate .' đã được thêm mới' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function update($request, $categories)
    {
        try {
            $this->categoriesRepository->update($request, $categories);
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return false;
        }
        return true;
    }



    public function destroy($id)
    {
        return $this->categoriesRepository->destroy($id);
    }



    public function getAllCategories()
    {
        return $this->categoriesRepository->getAllCategories();
    }


    public function getCategoryBySlug($slugCategory)
    {
        return $this->categoriesRepository->getCategoryBySlug($slugCategory);
    }
}
