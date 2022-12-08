<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\StorePostUpdateRequest;
use App\Http\services\categories\CategoriesServices;
use App\Http\services\post\PostServices;
use App\Models\Categories;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $postServices;
    protected $categoriesServices;

    public function __construct(PostServices $postServices, CategoriesServices $categoriesServices)
    {
        $this->postServices = $postServices;
        $this->categoriesServices = $categoriesServices;
    }

    public function  upload(Request $request)
    {
        $this->postServices->uploadImgFromTextarea($request);
    }

    public function index(Request $request)
    {
        $categories = $this->categoriesServices->getAllCategories();
        $result = $this->postServices->getPostsByParams($request);

        $posts = $result[0];
        $search = $result[1];
        $selected_option = $result[2];

        $search_categories_id = $search[0];
        $search_hot_flag = $search[1];
        $search_title = $search[2];
        $search_user = $search[3];

        $user = Auth::guard('admin')->user();
        return view('admin.post.list', [
            'title' => 'Trang quản trị danh sách post',
            'user' => $user,
            'posts' => $posts,
            'categories' => $categories,
            'search_categories_id' => $search_categories_id,
            'search_hot_flag' => $search_hot_flag,
            'search_title' => $search_title,
            'search_user' => $search_user,
        ]) ->with('i', (request()->input('page', 1) - 1) * $selected_option);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::guard('admin')->user();
        $categories = $this->categoriesServices->getAllCategories();
        return view('admin.post.add', [
            'title' => 'Thêm mới bài posts',
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $result =  $this->postServices->create($request);
        if($result)
        {
            return redirect()->route('admin.post.list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = Auth::guard('admin')->user();
        return view('admin.post.show', [
            'title' => 'Chi tiết bài viết: '. \Illuminate\Support\Str::limit($post->title, 40),
            'user' => $user,
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = $this->categoriesServices->getAllCategories();
        $user = Auth::guard('admin')->user();
        return view('admin.post.edit', [
            'title' => 'Sửa bài viết: '. \Illuminate\Support\Str::limit($post->title, 40),
            'user' => $user,
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostUpdateRequest $request, Post $post)
    {
        $result = $this->postServices->update($request, $post);
        if($result)
        {
            return redirect()->route('admin.post.list');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->postServices->getPostById($id);
        $result = $this->postServices->destroyById($id);

        if($result)
        {
            Session::flash('mySuccess', 'Bài Posts: ' . $post->title .' đã được xóa thành công!' );
            return redirect()->back();
        }
    }
}
