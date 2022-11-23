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
                                <label style="width: 175px;padding-top: 6px;">Người comments</label>
                                <input type="text" class="form-control" name="search_user" value="{{$search_user}}" placeholder="Nhập tên người comment">
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="input-group  mb-3">
                                <label style="margin-right: 59px;">Trạng thái</label>
                                <div class="form-group" style="display: flex;">
                                    <div class="form-check" style="padding-right: 8px;">
                                        <input class="form-check-input" type="radio" value="0" name="search_status" {{ $search_status == "0" ? 'checked' : '' }}>
                                        <label class="form-check-label">inactive</label>
                                    </div>
                                    <div class="form-check" style="padding-right: 8px;">
                                        <input class="form-check-input" type="radio" value="1" name="search_status" {{ $search_status == "1" ? 'checked' : '' }} >
                                        <label class="form-check-label">active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="margin-left: 40px;width: 76px;padding-top: 6px;">Bài viết</label>
                                <input type="text" class="form-control" name="search_post_title" value="{{$search_post}}" placeholder="Nhập tiêu đề bài viết">
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
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Số thứ tự</th>
                                <th>Người comments</th>
                                <th>Bài viết</th>
                                <th>Nội dung comments</th>
                                <th>Thời gian viết</th>
                                <th>Trạng thái</th>
                                <th>Kích hoạt</th>
                                <th>Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ $comment->first_name }} {{ $comment->last_name }}</td>
                                    <td>{{ $comment->posts_title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($comment->comment, 100) }}<a href=""  style="font-size: 11px;" class="text-danger"> <strong>xem thêm</strong> </a></td>
                                    <td>{{$comment->comment_time}}</td>
                                    <td class="text-center">
                                        @if ($comment->status == 0)
                                            x
                                        @elseif($comment->status == 1)
                                            ✓
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($comment->status == 0)
                                            <a href="{{route('admin.comment.active', $comment->id)}}"><button type="button" id="target" data-selected="true" value = "{{$comment->id}}" class="btn btn-success btl-active">Active</button></a>
                                        @endif
                                    </td>
                                    <td><a href="">link</a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="col-2" >
                                <button type="button" class="btn btn-success mt-3 mb-3 " id="btn-active-all" style="width: 230px;">Active All</button>
                            </div>
                        </div>
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
                {{ $comments->withQueryString()->onEachSide(0)->links() }}

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
{{--        active all--}}
//     console.log(($( ".btl-active" )).length)
//         for (let i = 0; i < $( ".btl-active" ).length; i++) {
//             text += cars[i] + "<br>";
//         }
//     console.log((($( ".btl-active" )[0])))
        dataIdActive = [];
        $( "#btn-active-all" ).click(function() {
            // console.log($( ".btl-active" ).val());
            // $(".btl-active").each(function(){
            //
            // }
            // $( ".btl-active" ).click();
            $( ".btl-active" ).each(function( i ) {
                // console.log($(this).val())
                dataIdActive.push($(this).val());
                // if ( this.style.color !== "blue" ) {
                //     this.style.color = "blue";
                // } else {
                //     this.style.color = "";
                // }
            });
            console.log( (dataIdActive))
        });

        //end active all


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
