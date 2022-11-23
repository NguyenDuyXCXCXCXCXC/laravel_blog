<?php

namespace App\Http\services\post;
use App\Models\Categories;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Session;

class PostServices
{

    public function getAllWithSearch($request)
    {
        $search_categories_id = '';
        $search_hot_flag = '';
        $search_title = '';
        $search_user = '';

        // search(4) categories, hot_flag, title, user
        if(($request->input('search_categories_id') != null) && ($request->input('search_hot_flag') != null) && ($request->input('search_title') != null) && ($request->input('search_user') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_hot_flag = $request->input('search_hot_flag');
            $search_title = $request->input('search_title');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(3)   hot_flag, title, user
        elseif (($request->input('search_hot_flag') != null) && ($request->input('search_title') != null) && ($request->input('search_user') != null)){
            $search_hot_flag = $request->input('search_hot_flag');
            $search_title = $request->input('search_title');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(3) categories, title, user
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_title') != null) && ($request->input('search_user') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_title = $request->input('search_title');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(3) categories, hot_flag, user
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_hot_flag') != null) && ($request->input('search_user') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_hot_flag = $request->input('search_hot_flag');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(3) categories, hot_flag, title
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_hot_flag') != null) && ($request->input('search_title') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_hot_flag = $request->input('search_hot_flag');
            $search_title = $request->input('search_title');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->orderByDesc('id')->paginate(7);
        }

        // search(2) categories, hot_flag
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_hot_flag') != null) ) {
            $search_categories_id = $request->input('search_categories_id');
            $search_hot_flag = $request->input('search_hot_flag');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->orderByDesc('id')->paginate(7);
        }
        // search(2) categories,  title
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_title') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_title = $request->input('search_title');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->orderByDesc('id')->paginate(7);
        }
        // search(2) categories, user
        elseif(($request->input('search_categories_id') != null) && ($request->input('search_user') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(2) hot_flag, title
        elseif( ($request->input('search_hot_flag') != null) && ($request->input('search_title') != null) ) {
            $search_hot_flag = $request->input('search_hot_flag');
            $search_title = $request->input('search_title');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->orderByDesc('id')->paginate(7);
        }
        // search(2) hot_flag,  user
        elseif(($request->input('search_hot_flag') != null) && ($request->input('search_user') != null)) {
            $search_hot_flag = $request->input('search_hot_flag');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        // search(2) title, user
        elseif( ($request->input('search_title') != null) && ($request->input('search_user') != null)) {
            $search_title = $request->input('search_title');
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }
        //search (1) categories
        elseif(($request->input('search_categories_id') != null)) {
            $search_categories_id = $request->input('search_categories_id');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('categories.id', '=', "{$search_categories_id}")
                ->orderByDesc('id')->paginate(7);
        }
        //search (1) hot_flag
        elseif( ($request->input('search_hot_flag') != null)) {
            $search_hot_flag = $request->input('search_hot_flag');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.hot_flag', '=', "{$search_hot_flag}")
                ->orderByDesc('id')->paginate(7);
        }
        //search (1) title
        elseif(($request->input('search_title') != null)) {
            $search_title = $request->input('search_title');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->where('posts.title', 'LIKE', "%{$search_title}%")
                ->orderByDesc('id')->paginate(7);
        }
        //search (1) user
        elseif(($request->input('search_user') != null)) {
            $search_user = $request->input('search_user');
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name')
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate(7);
        }


        // no search
        else{
            $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id' , 'users.first_name', 'users.last_name')
                ->orderByDesc('id')->paginate(7);
        }

        return [$posts, $search_categories_id, $search_hot_flag, $search_title, $search_user];
    }

    public function create($request)
    {
        $input = $request->all();
        try {
            $inputTitle = $input['title'];
            Post::create([
                'user_id' => $input['user_id'],
                'title' => $input['title'],
                'category_id' => $input['categories_id'],
                'hot_flag' => $input['hot_flag'],
                'content' => $input['content'],
                'post_time' => \Illuminate\Support\Carbon::now()->toDateTime()
            ]);
            Session::flash('mySuccess', 'Bài Posts: ' . $inputTitle .' đã được thêm mới' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function update($request, $post)
    {
        $postTitle = $post->title;
        try {
            $post->title = $request->title;
            $post->category_id = $request->categories_id;
            $post->hot_flag = $request->hot_flag;
            $post->content = $request->content;
            $post->save();
            Session::flash('mySuccess', 'Bài Posts: ' . $postTitle .' đã được sửa thành công!' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function destroy($id)
    {
        Post::find($id)->delete();
        return true;
    }
}
