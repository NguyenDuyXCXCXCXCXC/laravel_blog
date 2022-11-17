@extends('admin.main')

@section('content')
    @include('admin.alert')
    <div class="container-fluid">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / Users</label>
    </div>
    <div class="container-fluid">

        <div class="container card p-4 mt-3">
            <form action="{{ route('admin.user.list') }}" method="GET" >
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 102px;padding-top: 6px;">Email</label>
                        <input type="text" class="form-control" name="search"  placeholder="Nhập địa chỉ mail hoặc họ và tên">
                    </div>
                </div
                <div class="form-group" >
                    <div class="input-group  mb-3">
                        <label style="margin-right: 35px;">Giới tính</label>
                        <div class="form-group" style="display: flex;">
                            <div class="form-check" style="padding-right: 8px;">
                                <input class="form-check-input" type="radio" value="0" name="sex">
                                <label class="form-check-label">Nam</label>
                            </div>
                            <div class="form-check" style="padding-right: 8px;">
                                <input class="form-check-input" type="radio" value="1" name="sex">
                                <label class="form-check-label">Nữ</label>
                            </div>
                            <div class="form-check" style="padding-right: 8px;">
                                <input class="form-check-input" type="radio" value="2" name="sex">
                                <label class="form-check-label">Khác</label>
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
                @csrf
            </form>
        </div>

    </div>
<div class="container-fluid">
    <div class="row pt-5">
        <div class="col-12">
            <div class="card">
                <div class="col-3 pt-2">
                    <a href="{{route('admin.user.add')}}">
                        <button class="btn btn-primary">Thêm mới user</button>
                    </a>
                </div>
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-3 text-end" style="padding-left: 169px;padding-top: 7px;"">
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
                            <th>Email </th>
                            <th>Họ và tên</th>
                            <th>avatar</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->first_name}} {{$u->last_name}}</td>
                                    <td>
                                        @if($u->avatar == null || $u->avatar == '')
                                            ...
                                        @else
                                            <img src="/image/{{$u->avatar}}" alt="Avatar" class="avatar">
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->birthday == null || $u->birthday == '')
                                            ...
                                        @else
                                            {{$u->birthday}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (($u->sex) === 0)
                                            Nam
                                        @elseif (($u->sex) === 1)
                                            Nữ
                                        @else
                                            Khác
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->address == null || $u->address == '')
                                            ...
                                        @else
                                            {{$u->address}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (($u->role) === 1)
                                            Admin
                                        @elseif (($u->role) === 2)
                                            user
                                        @else
                                            manager
                                        @endif
                                    </td>
                                    <td>
                                        @if (($u->status) === 0)
                                            inactive
                                        @elseif (($u->status) === 1)
                                            active
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.edit',$u->id) }}"><button type="button" class="btn btn-primary">Sửa</button></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
{{--                                        <button type="button" class="btn btn-danger deleteRecord" onclick="delUser({{$u->id}})">Xóa</button>--}}
                                        <button type="button" class="btn btn-danger deleteRecord" data-id="{{ $u->id }}">Xóa</button>
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
            {{ $users->withQueryString()->onEachSide(0)->links() }}

        </div>
    </div>
</div>

    <script>
        $(".deleteRecord").click(function(){
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var isConfirm = confirm("Bạn chắc chắn muốn xóa user này?");
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
                    success: function (){
                        setTimeout(() =>{
                            location.reload();
                        }, 5000);

                    }
                });

        });
        // function delUser(id)
        // {
        //     var isConfirm = confirm("Bạn chắc chắn muốn xóa user này?");
        //     if (!isConfirm) {
        //         return;
        //     }
        //
        //     var token = $("meta[name='csrf-token']").attr("content");
        //     $.post("/admin/user/del",
        //         {
        //             "id": id,
        //             "_token": token,
        //         },
        //         function( status){
        //             console.log('status: '  + status);
        //         });
        // }
    </script>

@endsection