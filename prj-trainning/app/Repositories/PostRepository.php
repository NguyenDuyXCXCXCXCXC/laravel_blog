<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAllPost($request, $active = null){
        if ($active == 1){
            $postsActive = Post::orderByDesc('post_time')->where('hot_flag', '=', 1)
                ->limit(6)
                ->get();
            return $postsActive;
        }else{
            $postsActive = Post::orderByDesc('post_time')
                ->limit(6)
                ->get();
            return $postsActive;
        }

    }
    public function getAllPostById($id){

    }
}
