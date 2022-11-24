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
        $result = $this->commentServices->getAllAndSearch($request);
//        [$comments, $search_user, $search_post, $search_status];
        $comments = $result[0];
        $search_user = $result[1];
        $search_post = $result[2];
        $search_status = $result[3];
        $user = Auth::user();
        return view('admin.comment.list', [
            'title' => 'Trang quản trị danh sách comment',
            'user' => $user,
            'comments' => $comments,
            'search_user' => $search_user,
            'search_post' => $search_post,
            'search_status' => $search_status,
        ]) ->with('i', (request()->input('page', 1) - 1) * 7);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function active(Comment $comment)
    {
//        dd($comment->status);
        $comment->update(['status' => 1]);
        return redirect()->back();
    }

    public function activeAll($dataIdActive)
    {
        $dataIdActive = explode(",", $dataIdActive);
        foreach ($dataIdActive as $id)
        {
            $comment = Comment::where('id', $id)->first();
            $comment->update(['status' => 1]);
        }
    }
    public function inactive(Comment $comment)
    {
        $comment->update(['status' => 0]);
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::find($id)->delete();
        return redirect()->route('admin.comment.list');
    }
}
