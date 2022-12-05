<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepositories
{
    protected $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getcommentsByParams($search, $selected_option)
    {
        $search_user = $search[0];
        $search_status = $search[1];
        $search_post = $search[2];
        $query = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name');

        if($search_user != null && $search_user != ''){
            $query = $query->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                });
        }

        if($search_status != null && $search_status != ''){
            $query = $query->where('comments.status', '=', "{$search_status}");
        }

        if($search_post != null && $search_post != ''){
            $query = $query->where('posts.title', 'LIKE', "%{$search_post}%");
        }

        $comments = $query->orderByDesc('id')->paginate($selected_option);
        return $comments;
    }

    public function getCommmentById($id)
    {
        return $this->comment->where('id', $id)->first();
    }

    public function changeActiveComment($comment, $status)
    {
        return $comment->update(['status' => $status]);
    }

    public function destroyById($id)
    {
        return $this->comment->find($id)->delete();
    }

    public function createComment($input)
    {
        return $this->comment->create([
            'user_id' => $input['user_id'],
            'parent_id' => $input['parent_id'],
            'post_id' => $input['post_id'],
            'comment' => $input['comment'],
            'comment_time' => \Illuminate\Support\Carbon::now()->toDateTime()
        ]);
    }
}
