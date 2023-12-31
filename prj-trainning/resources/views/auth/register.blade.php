<!DOCTYPE html>
<html lang="en">
<head>
    @include('auth.layouts.head')
    <style>
        .form-check {
            margin-left: 15px;
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 520px;">
    <div class="register-logo">
        <p style="font-size: 21px;">Đăng ký</p>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            @include('auth.alert')
            <form action="{{route('client.register.post')}}" method="post" id="myForm">
                <input type="hidden" class="form-control" name="role" value="2" >
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 102px;padding-top: 6px;">Email<span style="color: red;">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ mail">
                    </div>
                    @if ($errors->has('email'))
                        <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="form-group" >
                    <div class="row" style="display: flex;">
                        <div class="col-5">
                            <div class="form-group" >
                                <div style="display: flex;">
                                    <label style="width: 169px;padding-top: 6px;">Họ<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Nhập họ">
                                </div>
                                @if ($errors->has('first_name'))
                                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-5" style="margin-left: 80px;">
                            <div class="form-group" >
                                <div style="display: flex;">
                                    <label style="width: 60px; padding-top: 6px;">Tên<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Nhập tên">
                                </div>
                                @if ($errors->has('last_name'))
                                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('last_name') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >
                        <div style="display: flex;">
                            <label style="width: 103px;padding-top: 0px;">Mật khẩu<span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password" id="password-field2" placeholder="Nhập mật khẩu">
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
                            <label style="width: 100px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Nhập mật khẩu confirm ">
                            <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password3" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
                        </div>
                        <p id="confirm_password_value" class="text-danger text-center" style="font-size: 12px;"></p>
                    </div>

                    <div class="input-group  mb-3">
                        <label style="margin-right: 8px;">Giới tính<span style="color: red;">*</span></label>
                        <div class="form-group" style="display: flex;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="sex" checked="">
                                <label class="form-check-label">Nam</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="sex">
                                <label class="form-check-label">Nữ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="2" name="sex">
                                <label class="form-check-label">Khác</label>
                            </div>
                        </div>
                    </div>

                    <div class="input-group  mb-3">
                        {{--                    <div class="form-group">--}}
                        <label style="width: 84px; padding-top: 6px;">Địa chỉ</label>
                        <textarea class="form-control" rows="1" cols="60" name="address"  placeholder="Nhập đia chỉ ..."> {{ old('address') }}</textarea>
                        {{--                    </div>--}}
                    </div>

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-success btn-block">Đăng ký</button>
                        </div>
                        <!-- /.col -->

                        <div class="col-6">
                            <a href="{{route('client.login')}}" ><button type="button" class="btn btn-primary btn-block">Đăng nhập</button></a>
                        </div>
                    </div>
                @csrf
            </form>

        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

@include('admin.users.layouts.footer')
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

    // check password comfirm
    $('#myForm').submit(function(){
        if($('[name=password]').val() != $('#confirm_password').val()){
            $('p#confirm_password_value').text('Mật khẩu xác nhận không chính xác!');
            console.log($('#confirm_password_value'));
            return false;
        }
        return true;
    })
</script>
</body>
</html>
