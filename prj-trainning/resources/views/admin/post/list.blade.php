@extends('admin.main')

@section('content')

    <div class="row pt-2">
        <div class="col-8"></div>
        <div class="alert-delete col-3">
            @include('admin.alert')
        </div>
    </div>

    <div class="container-fluid">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / Categories</label>
    </div>
    <div class="container-fluid">

        <div class="container card p-4 mt-3">
            <form action="" method="GET" >
                <div class="row">
                    <div class="col-6">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 102px;padding-top: 6px;">Danh mục </label>
{{--                                {{dd($search_categories_id);}}--}}
                                <select class="form-control form-select" name="search_categories_id" aria-label="Default select example">
                                    <option value="">Lựa chọn danh sách danh mục</option>
                                    @foreach($categories as $ca)
                                        <option value="{{$ca->id}}" {{$ca->id == $search_categories_id ? 'selected' : '' }}>{{$ca->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="input-group  mb-3">
                                <label style="margin-right: 35px;">Nổi bật</label>
                                <div class="form-group" style="display: flex;">
                                    <div class="form-check" style="padding-right: 8px;">
                                        <input class="form-check-input" type="radio" value="0" name="search_hot_flag" {{ $search_hot_flag == "0" ? 'checked' : '' }}>
                                        <label class="form-check-label">inactive</label>
                                    </div>
                                    <div class="form-check" style="padding-right: 8px;">
                                        <input class="form-check-input" type="radio" value="1" name="search_hot_flag" {{ $search_hot_flag == "1" ? 'checked' : '' }} >
                                        <label class="form-check-label">active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 102px;padding-top: 6px;">Tiêu đề</label>
                                <input type="text" class="form-control" name="search_title" value="{{$search_title}}" placeholder="Nhập tiêu đề">
                            </div>
                        </div>
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 102px;padding-top: 6px;">Tác giả</label>
                                <input type="text" class="form-control" name="search_user" value="{{$search_user}}" placeholder="Nhập tên tác giả">
                            </div>
                        </div>
                    </div>
                </div>


                    <div class="row">
                        <!-- /.col -->
                        <div class="col-8">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-success ">Tìm kiếm</button>
                        </div>
                        <!-- /.col -->
                    </div>
            </form>
        </div>

    </div>
    <div class="container-fluid">
        <div class="row pt-5">
            <div class="col-12">
                <div class="card">
                    <div class="col-3 pt-2">
                        <a href="{{route('admin.post.add')}}">
                            <button class="btn btn-primary">Thêm mới bài post</button>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-2">
                        </div>
                        <div class="col-3 text-end" style="padding-left: 169px;padding-top: 7px;">
                        Lựa chọn số lượng record hiển thị :
                    </div>
                    <div class="col-5 text-start pt-1" >
                        <select class="form-control" name="select-num" style="width: 86px;">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh bài viết</th>
                            <th>Danh mục</th>
                            <th>Tác giả</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái nổi bật</th>
                            <th>Nội dung</th>
                            <th>Thời gian viết</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{\Illuminate\Support\Str::limit($post->title, 30)}}</td>
                                <td>
                                    @if($post->photo == null || $post->photo == '')
                                        <img src="/image/images.png" alt="Avatar" class="avatar rounded mx-auto d-block">
                                    @else
                                        <img src="/image/{{$post->photo}}" alt="Avatar" class="avatar rounded mx-auto d-block">
                                    @endif
                                </td>
                                <td>{{$post->categories_name}}</td>
                                <td>{{$post->first_name}} {{$post->last_name}}</td>
                                <td class="text-center">
                                    @if ($post->views != null && $post->views > 0)
                                        {{$post->views}}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($post->hot_flag == 0)
                                        <p class="text-danger">inactive</p>
                                    @elseif ($post->hot_flag == 1)
                                        <p class="text-success">active</p>
                                    @endif
                                </td>
                                <td>{!! \Illuminate\Support\Str::limit($post->content, 40) !!}<a  style="font-size: 11px;" href="{{route('admin.post.show', $post->id)}}" class="text-danger"><strong>xem thêm</strong> </a></td>
                                <td>{{$post->post_time}}</td>
                                <td>
                                    <a href="{{ route('admin.post.edit',$post->id) }}"><button type="button" class="btn btn-primary">Sửa</button></a>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <form action="{{ route('admin.post.destroy',$post->id) }}" method="POST" style="display: inline;">
                                        <button type="button" class="btn btn-danger deleteRecord "  data-id="{{ $post->id }}">Xóa</button>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>

    {{--    {!! $users->links() !!}--}}
    <div class="row">
        <div class="col-7">
        </div>
        <div class="col-5">
            {{ $posts->withQueryString()->onEachSide(0)->links() }}

        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        if( $(".alert").text() != ''){
            setTimeout(() =>{
                $(".alert").removeClass('alert alert-danger alert-success').text('')
            }, 5000);
        }
        // console.log('Duy: ' + $(".alert").text());
        $(".deleteRecord").click(function(){
            // var id = $(this).data("id");
            var form =  $(this).closest("form");
            // var emailRemove = $(this).data("email");
            // var token = $("meta[name='csrf-token']").attr("content");

            // for alert
            swal({
                title: `Bạn có chắc chắn muốn xóa bản ghi này?`,
                text: "Nếu bạn đồng ý xóa, nó sẽ biến mất mãi mãi.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        // $.ajax(
                        //     {
                        //         url: "/admin/user/del/"+id,
                        //         type: 'DELETE',
                        //         data: {
                        //             "id": id,
                        //             "_token": token,
                        //         },
                        //         success: function (result){
                        //             location.reload();
                        //             setTimeout(() =>{
                        //                 $('.alert-delete').addClass("alert-success alert").text('Tài khoản '+ emailRemove +' đã được xóa!');
                        //             }, 2000);
                        //             // $('.alert-delete').addClass("alert-success alert").text('Tài khoản '+ emailRemove +' đã được xóa!');
                        //             // alert(result.message);
                        //             setTimeout(() =>{
                        //                 location.reload();
                        //             }, 3000);
                        //
                        //         }
                        //     });
                    }
                });



        });
    </script>

@endsection
