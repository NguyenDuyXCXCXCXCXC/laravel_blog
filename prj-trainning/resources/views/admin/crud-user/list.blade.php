@extends('admin.main')

@section('content')
    @include('admin.alert')
    <div class="container-fluid">
        <label class="pl-5">Home / Users</label>
    </div>
    <div class="container-fluid">
        <div class="container card p-4 mt-3">
            <form action="" method="post" >
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 102px;padding-top: 6px;"">Email</label>
                        <input type="text" class="form-control" name="search"  placeholder="Nhập địa chỉ mail hoặc họ và tên">
                    </div>
                </div

                <div class="form-group" >
                    <div class="input-group  mb-3">
                        <label style="margin-right: 35px;">Giới tính</label>
                        <div class="form-group" style="display: flex;">
                            <div class="form-check" style="padding-right: 8px;">
                                <input class="form-check-input" type="radio" value="0" name="sex" checked="">
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
                            @foreach($users as $user)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->first_name}} {{$user->last_name}} {{$user->id}}</td>
                                    <td>
                                        @if($user->avatar == null || $user->avatar == '')
                                            ...
                                        @else
                                            <img src="{{$user->avatar}}" alt="Avatar" class="avatar">
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->birthday == null || $user->birthday == '')
                                            ...
                                        @else
                                            {{$user->birthday}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (($user->sex) === 0)
                                            Nam
                                        @elseif (($user->sex) === 1)
                                            Nữ
                                        @else
                                            Khác
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->address == null || $user->address == '')
                                            ...
                                        @else
                                            {{$user->address}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (($user->role) === 1)
                                            Admin
                                        @elseif (($user->role) === 2)
                                            user
                                        @else
                                            manager
                                        @endif
                                    </td>
                                    <td>
                                        @if (($user->status) === 0)
                                            inactive
                                        @elseif (($user->status) === 1)
                                            active
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary">Sửa</button>
                                        <button type="button" class="btn btn-danger">Xóa</button>
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
            {{ $users->onEachSide(5)->links() }}
        </div>
    </div>
</div>


@endsection
