<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
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

    public function __construct(PostServices $postServices)
    {
        $this->postServices = $postServices;
    }

    public function  upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $userId = Auth::user()->id;
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.$userId.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('image'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('image/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function index(Request $request)
    {
        $categories = Categories::all();
        $result = $this->postServices->getAllWithSearch($request);
        $posts = $result[0];
        $search_categories_id = $result[1];
        $search_hot_flag = $result[2];
        $search_title = $result[3];
        $search_user = $result[4];
        $user = Auth::user();
        return view('admin.post.list', [
            'title' => 'Trang quản trị danh sách post',
            'user' => $user,
            'posts' => $posts,
            'categories' => $categories,
            'search_categories_id' => $search_categories_id,
            'search_hot_flag' => $search_hot_flag,
            'search_title' => $search_title,
            'search_user' => $search_user,
        ]) ->with('i', (request()->input('page', 1) - 1) * 7);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::user();
        $categories = Categories::all();
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
        $user = Auth::user();
        return view('admin.post.show', [
            'title' => 'chi tiết bài viết: '. \Illuminate\Support\Str::limit($post->title, 40),
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
//        dd($post);
        $categories = Categories::all();
        $user = Auth::user();
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
    public function update(StorePostRequest $request, Post $post)
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
        $post = Post::where('id', $id)->first();
        $result = $this->postServices->destroy($id);
        if($result)
        {
            Session::flash('mySuccess', 'Bài Posts: ' . $post->title .' đã được xóa thành công!' );
            return redirect()->back();
        }
    }
}
