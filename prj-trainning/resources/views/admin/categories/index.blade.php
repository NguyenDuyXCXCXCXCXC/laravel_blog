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
                        <input type="text" class="form-control" name="search" value="{{ $search  }}"  placeholder="Nhập tên danh mục">
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
    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="card">
                    <div class="col-3 pt-2">
                        <a href="{{route('admin.categories.add')}}">
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
                        <table class="table table-hover table-bordered text-nowrap">
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
                                                <a href="{{ route('admin.categories.edit',$cate->id) }}"><button type="button" class="btn btn-primary">Sửa</button></a>
{{--                                                <meta name="csrf-token" content="{{ csrf_token() }}">--}}
                                                <form action="{{ route('admin.categories.destroy',$cate->id) }}" method="POST" style="display: inline;">
                                                    <button type="button" class="btn btn-danger deleteRecord" data-name = "{{$cate->name}}" data-id="{{ $cate->id }}">Xóa</button>
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
                {{ $categories->withQueryString()->onEachSide(0)->links() }}
{{--                {{ $categories->links() }}--}}
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
            var id = $(this).data("id");
            var form =  $(this).closest("form");
            var categoriesRemove = $(this).data("name");
            var token = $("meta[name='csrf-token']").attr("content");

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
                        //         url: "/admin/categories/del/"+id,
                        //         type: 'DELETE',
                        //         data: {
                        //             "id": id,
                        //             "_token": token,
                        //         },
                        //         success: function (result){
                        //             $('.alert-delete').addClass("alert-success alert").text('Danh mục '+ categoriesRemove +' đã được xóa!');
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
