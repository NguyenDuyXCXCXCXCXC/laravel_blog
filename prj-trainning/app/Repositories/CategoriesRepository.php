<?php

namespace App\Repositories;

use App\Interfaces\CategoriesRepositoryInterface;
use App\Models\Categories;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    protected $categories;
    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }

    public function getAllCategories()
    {
        return $this->categories::orderByDesc('id')->get();
    }

    public function getCategoriesByParams($search, $selected_option)
    {
        $query = $this->categories::query();
        if(!empty($search)){
            $query = $query->where('name', 'LIKE', "%{$search}%");
        }
        return $query->orderByDesc('id')->paginate($selected_option);
    }

    public function create($inputCate)
    {
        return $this->categories::create([
            'name' => $inputCate
        ]);
    }

    public function update($request, $categories)
    {
        $categories->name = $request->input('categories');
        $categories->save();
        return $categories;
    }

    public function destroy($id)
    {
        return $this->categories->find($id)->delete();
    }

}
