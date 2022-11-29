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
        $categories = Categories::orderByDesc('id')->get();
        return $categories;
    }

}
