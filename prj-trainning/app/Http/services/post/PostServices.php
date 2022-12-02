<?php

namespace App\Http\services\post;
use App\Models\Categories;
use App\Models\User;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Session;

class PostServices
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPostByParams($request)
    {
        // su dung cho phan select so luong ban ghi
        if ($request->input('selected_option') != null && $request->input('selected_option') != ''){
            $selected_option = (int)($request->input('selected_option'));
        }else{
            $selected_option = 7;
        }

        $search_categories_id = $request->input('search_categories_id');
        $search_hot_flag = $request->input('search_hot_flag');
        $search_title = $request->input('search_title');
        $search_user = $request->input('search_user');
        $search = [$search_categories_id, $search_hot_flag, $search_title, $search_user];

        $posts = $this->postRepository->getPostByParams($search, $selected_option);
        return [$posts, $search, $selected_option];
    }

    public function create($request)
    {
        $input = $request->all();
        $idUserCreater = Auth::user()->id;
        if ($image = $request->file('photo')) {
            $destinationPath = 'image/';
            $profileImage = $idUserCreater . '_' . time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        try {
            $inputTitle = $input['title'];
            $this->postRepository->create($input);
            Session::flash('mySuccess', 'Bài Posts: ' . $inputTitle .' đã được thêm mới' );
        }catch (\Exception $err){
            Session::flash('myError', $err->getMessage() );
            return false;
        }
        return true;
    }

    public function uploadImgFromTextarea($request)
    {
        if ($request->hasFile('upload')) {
            $userId = Auth::user()->id;
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . $userId . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('image'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('image/' . $fileName);
            $msg = 'Hình ảnh được tải lên thành công!';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function update($request, $post)
    {
        $request->validate([
            'title'  =>'required|max:200',
            'categories_id' =>'required',
            'hot_flag' =>'required',
            'content' =>'required',
            'photo'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.max' => 'Tiêu đề không vượt quá 200 ký tự!',
            'categories_id.required' => 'Danh mục không được để trống!',
            'hot_flag.required' => 'Trạng thái nổi bật không được để trống!',
            'content.required' => 'Nội dung bài viết không được để trống!',
            'photo.image' => 'Yêu cầu file định dạng phải là ảnh!',
            'photo.max' => 'Yêu cầu kích thước <= 10MB!',
        ]);
        $input = $request->all();
        $postTitle = $post->title;
        $idUserCreater = Auth::user()->id;
        if ($image = $request->file('photo')) {
            $destinationPath = 'image/';
            $profileImage = $idUserCreater . '_' . time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }

        // bien request ko dat giong database
        $input['category_id'] = $input['categories_id'];
        unset($input['categories_id']);
//        dd($input['categories_id']);
//        dd($input, $post);
        try {
            $post->update($input);
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




    //    ==== for client ===
    public function getPostDashboard($request, $active = null)
    {
        return $this->postRepository->getAllPost($request, $active);
    }

}
