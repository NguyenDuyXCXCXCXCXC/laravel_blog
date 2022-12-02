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
}
