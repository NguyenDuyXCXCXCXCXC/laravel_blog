<?php

namespace App\Http\Controllers;

use App\Http\services\categories\CategoriesServices;
use App\Http\services\comment\CommentServices;
use App\Http\services\post\PostServices;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $categoriesServices;
    protected $postsServices;
    protected $commentServices;

    public function __construct(CategoriesServices $categoriesServices, PostServices $postsServices, CommentServices $commentServices)
    {
        $this->categoriesServices = $categoriesServices;
        $this->postsServices = $postsServices;
        $this->commentServices = $commentServices;
    }

    public function index(Request $request)
    {
        $title = 'Trang chủ';
        $categories =  $this->categoriesServices->getAllCategories();
        $postsInDayActive = $this->postsServices->getPostsInDayActiveDashboardByParams($request);
        $postsInDay = $this->postsServices->getPostsInDayDashboardByParams($request);
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
        if (empty($category))
        {
            return redirect()->back();
        }
        $idCategory = $category->id;
        $postsInDayActiveBySluCategory = $this->postsServices->getPostsActiveByIdCategoryAndParams($request, $idCategory);
        return view('category', [
            'title' => $title,
            'categories' => $categories,
            'posts' => $postsInDayActiveBySluCategory,
            'search' => $request->search
        ]);
    }

    public function indexPost(Request $request, $slugPost)
    {
        $post = $this->postsServices->getPostBySlug($slugPost);
        $addView = $this->postsServices->addViewPost($post);

        if (empty($post))
        {
            return redirect()->back();
        }
        $title = $post->title;
        $categories =  $this->categoriesServices->getAllCategories();
        $idCategoryByPost = $post->category_id;
        $idPost = $post->id;
        $postRandom = $this->postsServices->getPostsByIdCategoryRandom($request, $idCategoryByPost, $idPost);
        return view('post', [
            'title' => $title,
            'categories' => $categories,
            'post' => $post,
            'postRandom' => $postRandom,
            'search' => $request->search
        ]);

    }

    public function postComment(Request $request)
    {
//        $post = $this->postsServices->getPostById($request->post_id);
        $result = $this->commentServices->createComment($request);
        return $result;
    }



}
