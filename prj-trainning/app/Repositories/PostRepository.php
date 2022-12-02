<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPostByParams($search, $selected_option)
    {
        $search_categories_id = $search[0];
        $search_hot_flag = $search[1];
        $search_title = $search[2];
        $search_user = $search[3];

        $query = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'categories.name as categories_name', 'categories.id as categories_id', 'users.first_name', 'users.last_name');
        if(!empty($search_categories_id)){
            $query = $query->where('categories.id', '=', "{$search_categories_id}");
        }

        if($search_hot_flag != null && $search_hot_flag != ''){
            $query = $query->where('posts.hot_flag', '=', "{$search_hot_flag}");
        }

        if(!empty($search_title)){
            $query = $query->where('posts.title', 'LIKE', "%{$search_title}%");
        }

        if(!empty($search_user)){
            $query = $query->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                });
        }

        $posts = $query->orderByDesc('id')->paginate($selected_option);
        return $posts;
    }

    public function create($input)
    {
        return $this->post->create([
            'user_id' => $input['user_id'],
            'title' => $input['title'],
            'category_id' => $input['categories_id'],
            'hot_flag' => $input['hot_flag'],
            'content' => $input['content'],
            'photo' => $input['photo'],
            'post_time' => \Illuminate\Support\Carbon::now()->toDateTime()
        ]);
    }


    public function update($post, $input)
    {
        $post->update($input);
    }


    public function getPostById($id)
    {
        return $this->post->findOrFail($id);
    }

    public function destroyById($id)
    {
        $post = Post::find($id);
        return $post->delete();
    }



    public function getPostInDayDashboard($searchRequest, $active)
    {
        $query = $this->post->query();
        if ($active != null){
            $query = $query->where('hot_flag', '=', $active);
        }
        if(!empty($searchRequest)){
            $query = $query->where('title', 'LIKE', "%{$searchRequest}%");
        }
        return $query->orderByDesc('post_time')->limit(6)->get();
    }


    public function getPostsByIdCategoryDashboard($searchRequest, $idCategory)
    {
        $query = $this->post->query();
        if(!empty($searchRequest)){
            $query = $query->where('title', 'LIKE', "%{$searchRequest}%");
        }
        $query = $query->where('category_id', '=', "{$idCategory}");
        return $query->orderByDesc('post_time')->limit(4)->get();
    }


}
