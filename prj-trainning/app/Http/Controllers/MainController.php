<?php

namespace App\Http\Controllers;

use App\Http\services\categories\CategoriesServices;
use App\Http\services\post\PostServices;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $categoriesServices;
    protected $postsServices;

    public function __construct(CategoriesServices $categoriesServices, PostServices $postsServices)
    {
        $this->categoriesServices = $categoriesServices;
        $this->postsServices = $postsServices;
    }

    public function index(Request $request)
    {
        $title = 'Trang chủ';
        $categories =  $this->categoriesServices->getAllCategories();
        $postsInDayActive = $this->postsServices->getPostInDayActiveDashboardByParams($request);
        $postsInDay = $this->postsServices->getPostInDayDashboardByParams($request);
        $postsByCategoryFirst = $this->postsServices->getPostsByIdCategoryDashboard($request, $categories[0]->id);
        $postsByCategorySecond = $this->postsServices->getPostsByIdCategoryDashboard($request, $categories[1]->id);
        $postsByCategoryThird = $this->postsServices->getPostsByIdCategoryDashboard($request, $categories[2]->id);


        return view('home', [
            'title' => $title,
            'categories' => $categories,
            'postsInDayActive' => $postsInDayActive,
            'postsInDay' =>$postsInDay,
            'postsByCategoryFirst' => $postsByCategoryFirst,
            'postsByCategorySecond' => $postsByCategorySecond,
            'postsByCategoryThird' => $postsByCategoryThird,
            'search' => $request->search
        ]);
    }


    public function indexCategory(Request $request, $slugCategory)
    {
        $title = 'Trang chủ';
        $categories =  $this->categoriesServices->getAllCategories();
        $category = $this->categoriesServices->getCategoryBySlug($slugCategory);
        $idCategory = $category->id;
        $postsInDayActiveBySluCategory = $this->postsServices->getPostsActiveByIdCategoryAndParams($request, $idCategory);
//        dd($postsInDayActiveBySluCategory);
        return view('category', [
            'title' => $title,
            'categories' => $categories,
            'posts' => $postsInDayActiveBySluCategory,
            'search' => $request->search
        ]);
    }

}
