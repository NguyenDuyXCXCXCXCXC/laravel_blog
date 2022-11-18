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
    <div class="container">

        <div class="container card p-4 mt-3">
            <form action="" method="GET" >
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 124px;padding-top: 6px;">Tên danh mục</label>
                        <input type="text" class="form-control" name="search"  placeholder="Nhập tên danh mục">
                    </div>
                </div>

                @csrf
            </form>
        </div>

    </div>
    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="card">
                    <div class="col-3 pt-2">
                        <a href="">
                            <button class="btn btn-primary">Thêm mới danh mục</button>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-2">
                        </div>
                        <div class="col-3" style="padding-left: 39px;padding-top: 7px;">
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
                                    <th>Danh mục</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($categories as $cate)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$cate->name}}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit',$cate->id) }}"><button type="button" class="btn btn-primary">Sửa</button></a>
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                    <button type="button" class="btn btn-danger deleteRecord" data-email = "{{$cate->email}}" data-id="{{ $cate->id }}">Xóa</button>
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
{{--                {{ $users->withQueryString()->onEachSide(0)->links() }}--}}

            </div>
        </div>
    </div>

    <script>
        if( $(".alert").text() != ''){
            setTimeout(() =>{
                $(".alert").removeClass('alert alert-danger alert-success').text('')
            }, 5000);
        }
        // console.log('Duy: ' + $(".alert").text());
        $(".deleteRecord").click(function(){
            var id = $(this).data("id");
            var emailRemove = $(this).data("email");
            var token = $("meta[name='csrf-token']").attr("content");
            var isConfirm = confirm("Bạn chắc chắn muốn xóa user này?");
            console.log(isConfirm);
            if (!isConfirm) {
                return;
            }
            $.ajax(
                {
                    url: "/admin/user/del/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (result){
                        $('.alert-delete').addClass("alert-success alert").text('Tài khoản '+ emailRemove +' đã được xóa!');
                        // alert(result.message);
                        setTimeout(() =>{
                            location.reload();
                        }, 3000);

                    }
                });

        });
    </script>

@endsection