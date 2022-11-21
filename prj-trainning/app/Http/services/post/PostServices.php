<?php

namespace App\Http\services\post;
use App\Models\Categories;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostServices
{

    public function getAll($request)
    {
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id' , 'users.first_name', 'users.last_name')
            ->get();
        return $posts;
    }
}
