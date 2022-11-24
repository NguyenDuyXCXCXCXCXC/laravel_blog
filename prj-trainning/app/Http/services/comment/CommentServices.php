<?php

namespace App\Http\services\comment;

use Illuminate\Support\Facades\DB;

class CommentServices
{
    public function getAllAndSearch($request)
    {
        $search_user = '';
        $search_post = '';
        $search_status = '';
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }
        // search(3) user, status, post
        if(($request->input('search_user') != null) && $request->input('search_status') != null && $request->input('search_post_title') != null)
        {
            $search_user = $request->input('search_user');
            $search_status = $request->input('search_status');
            $search_post = $request->input('search_post_title');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->where('comments.status', '=', "{$search_status}")
                ->where('posts.title', 'LIKE', "%{$search_post}%")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(2) status, post
        elseif( $request->input('search_status') != null && $request->input('search_post_title') != null)
        {
            $search_status = $request->input('search_status');
            $search_post = $request->input('search_post_title');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->where('comments.status', '=', "{$search_status}")
                ->where('posts.title', 'LIKE', "%{$search_post}%")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(2) user, post
        elseif(($request->input('search_user') != null) && $request->input('search_post_title') != null)
        {
            $search_user = $request->input('search_user');
            $search_post = $request->input('search_post_title');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->where('posts.title', 'LIKE', "%{$search_post}%")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(2) user, status
        elseif(($request->input('search_user') != null) && $request->input('search_status') != null )
        {
            $search_user = $request->input('search_user');
            $search_status = $request->input('search_status');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->where('comments.status', '=', "{$search_status}")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(1) user
        elseif(($request->input('search_user') != null) )
        {
            $search_user = $request->input('search_user');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->Where(function ($query) use ($search_user) {
                    $query->orwhere('users.last_name', 'LIKE', "%{$search_user}%")
                        ->orwhere('users.first_name', 'LIKE', "%{$search_user}%");
                })
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(1)  status
        elseif($request->input('search_status') != null )
        {
            $search_status = $request->input('search_status');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->where('comments.status', '=', "{$search_status}")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(1) post
        elseif($request->input('search_post_title') != null)
        {
            $search_post = $request->input('search_post_title');
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->where('posts.title', 'LIKE', "%{$search_post}%")
                ->orderByDesc('id')->paginate($selected_option);
        }
        // search(0)
        else{
            $comments = DB::table('comments')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'posts.title as posts_title' , 'posts.id as posts_id' , 'users.first_name', 'users.last_name')
                ->orderByDesc('id')->paginate($selected_option);
        }

//        dd($comments);
        return [$comments, $search_user, $search_post, $search_status, $selected_option];
    }

}
