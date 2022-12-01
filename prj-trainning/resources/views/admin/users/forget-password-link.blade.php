<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.users.layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1><b>Quản trị viên</b></h1>
            <p>Thay đổi mật khẩu</p>
        </div>
        @if (\Illuminate\Support\Facades\Session::has('myError'))
            <div class="alert alert-danger">
                {{ \Illuminate\Support\Facades\Session::get('myError') }}
            </div>
        @endif
        <div class="card-body">
            <form action="{{route('admin.reset.password.post')}}" method="post" id="myForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="hidden" name="email"  value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                </div>
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 104px;padding-top: 6px;">Mật khẩu<span style="color: red;">*</span></label>
                        <input type="password" class="form-control" name="password" id="password-field2" placeholder="Nhập mật khẩu">
                        <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password2" style="
                                                                                    float: right;
                                                                                    margin-left: -25px;
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
                        <label style="width: 105px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Nhập mật khẩu confirm">
                        <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password3" style="
                                                                                    float: right;
                                                                                    margin-left: -25px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
                    </div>
                    <p id="confirm_password_value" class="text-danger text-center" style="font-size: 12px;"></p>
                </div>
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Hoàn thành</button>
                    </div>

                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

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

    // cofirm password
    $('#myForm').submit(function(){
        if($('[name=password]').val() != $('#confirm_password').val()){
            $('p#confirm_password_value').text('Mật khẩu xác nhận không chính xác!');
            return false;
        }
        return true;
    })
</script>
</body>
</html>
