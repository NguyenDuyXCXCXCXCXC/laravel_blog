@extends('admin.main')

@section('content')
    @include('admin.alert')
    <h2 class="text-center mt-3">Đổi PassWord</h2>
    <div class="container mt-3 mb-3">
        @include('admin.alert')
        <form action="{{route('admin.profile.updatePassword')}}" method="post" id="myForm" >

            <div class="form-group" >
                <div style="display: flex;">
                    <input type="text" class="form-control" name="id_user_changepass" value="{{$id}}">
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 103px;padding-top: 0px;">Mật khẩu cũ<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password_old" placeholder="Nhập mật khẩu">
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 103px;padding-top: 0px;">Mật khẩu<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
                </div>
                @if ($errors->has('password'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 101px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập mật khẩu confirm ">
                </div>
                @if ($errors->has('password_confirmation'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>


            <div class="row pb-2">
                <!-- /.col -->
                <div class="col-2">
                    <button type="submit" class="btn btn-success btn-block">Hoàn thành</button>
                </div>
                <!-- /.col -->
                <div class="col-2"></div>
                <div class="col-6"></div>
                <div class="col-2">
                    <a href="{{route('admin.profile.edit')}}" ><button type="button" class="btn btn-primary btn-block">Quay lại</button></a>
                </div>
            </div>
            @csrf
        </form>

    </div>
@endsection
