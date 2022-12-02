@extends('admin.main')
@section('content')
    <div class="container-fluid">
        <label class="pl-5">
            <a href="{{route('admin.dashboard')}}">Home</a>
            @if($userEdit->role == 2)
                / <a href="{{route('admin.user.listForUser')}}">Users</a>
            @else
                / <a href="{{route('admin.user.list')}}">Users</a>
            @endif

            / Edit
        </label>
    </div>
    @include('admin.users.alert')
    <div class="container">
        @include('admin.alert')
        <form action="{{route('admin.user.updatePassword', $userEdit->id)}}" method="post" id="myForm" >
            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 103px;padding-top: 0px;">Mật khẩu<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password" id="password-field2" placeholder="Nhập mật khẩu ">
                    <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password2" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
                </div>
                @if ($errors->has('password'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 101px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" id="password-field3" placeholder="Nhập mật khẩu confirm ">
                    <span toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password3" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
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
                    <a href="{{route('admin.user.edit', $userEdit->id)}}" ><button type="button" class="btn btn-primary btn-block">Quay lại</button></a>
                </div>
            </div>

            @csrf
        </form>

    </div>
    <script>
        // show hide password

        $(".toggle-password2").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password3").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        // end show hide password
    </script>
@endsection
