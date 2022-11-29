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
        $postsActive = $this->postsServices->getPostDashboard($request, $active = 1);
        $posts = $this->postsServices->getPostDashboard($request);

        return view('home', [
            'title' => $title,
            'categories' => $categories,
            'postsActive' => $postsActive,
            'posts' =>$posts
        ]);
    }
}
