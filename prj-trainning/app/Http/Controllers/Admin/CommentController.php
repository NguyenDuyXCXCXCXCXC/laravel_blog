<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\services\comment\CommentServices;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $commentServices;
    public function __construct(CommentServices $commentServices)
    {
        $this->commentServices = $commentServices;
    }

    public function index(Request $request)
    {
        $result = $this->commentServices->getcommentsByParams($request);
        $comments = $result[0];
        $search = $result[1];
        $selected_option = $result[2];

        $search_user = $search[0];
        $search_status = $search[1];
        $search_post = $search[2];

        $user = Auth::user();
        return view('admin.comment.list', [
            'title' => 'Trang quản trị danh sách comment',
            'user' => $user,
            'comments' => $comments,
            'search_user' => $search_user,
            'search_post' => $search_post,
            'search_status' => $search_status,
        ]) ->with('i', (request()->input('page', 1) - 1) * $selected_option);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function active(Comment $comment)
    {
        $this->commentServices->activeComment($comment);
        return redirect()->back();
    }

    public function activeAll($dataIdActive)
    {
        $this->commentServices->activeAllComment($dataIdActive);
    }
    public function inactive(Comment $comment)
    {
        $this->commentServices->inactiveComment($comment);
        return redirect()->back();
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
//        dd($comment->user->first_name, $comment->user->last_name, $comment->post->title);
        $user = Auth::user();
        return view('admin.comment.show', [
            'title' => 'Chi tiết comment',
            'user' => $user,
            'comment' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->commentServices->destroyById($id);
        if ($result){
            return redirect()->route('admin.comment.list');
        }
    }
}
