<?php

namespace App\Http\services\comment;

use App\Repositories\CommentRepositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentServices
{
    protected $commentRepositories;
    public function __construct(CommentRepositories $commentRepositories)
    {
        $this->commentRepositories = $commentRepositories;
    }

    public function getcommentsByParams($request)
    {

        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }

        $search_user = $request->input('search_user');
        $search_status = $request->input('search_status');
        $search_post = $request->input('search_post_title');
        $search = [$search_user, $search_status, $search_post];

        $comments = $this->commentRepositories->getcommentsByParams($search, $selected_option);

        return [$comments, $search, $selected_option];
    }

    public function activeComment($comment)
    {
        return $this->commentRepositories->changeActiveComment($comment, $status = 1);
    }

    public function activeAllComment($dataIdActive)
    {
        $dataIdActive = explode(",", $dataIdActive);
        foreach ($dataIdActive as $id)
        {
            $comment = $this->commentRepositories->getCommmentById($id);
            $this->commentRepositories->changeActiveComment($comment, $status = 1);
        }
    }

    public function inactiveComment($comment)
    {
        $this->commentRepositories->changeActiveComment($comment, $status = 0);
    }

    public function destroyById($id)
    {
        try {
            $this->commentRepositories->destroyById($id);
        }catch (\Exception $exception)
        {
            Log::info($exception->getMessage());
            return false;
        }
        return true;
    }

}
