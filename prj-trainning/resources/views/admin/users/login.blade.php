<!DOCTYPE html>
<html lang="en">
<head>


    @include('admin.users.layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Quản trị viên</b>
        <p style="font-size: 21px;">Đăng nhập</p>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            @include('admin.users.alert')
            <form action="/admin/login/store" method="post">
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 100px;" padding-top: 6px;">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="Nhập địa chỉ mail">
                    </div>

                    @if ($errors->has('email'))
                        <p class="text-danger text-center">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 100px;" padding-top: 6px;">Mật khẩu</label>
                        <input type="password" class="form-control " name="password" id="password-field2" placeholder="Nhập mật khẩu">
                        <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password2" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>

                    </div>
                    @if ($errors->has('password'))
                        <p class="text-danger text-center">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <a href="{{ route('admin.register') }}" class="text-center">
                            <button type="button" class="btn btn-success btn-block">Đăng ký</button>
                        </a>
                    </div>
                    <!-- /.col -->
                </div>
                @csrf
            </form>


            <!-- /.social-auth-links -->

            <p class="mb-1 text-center">
                <a href="{{ route('admin.forget-password') }}">Quên mật khẩu ?</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

{{--{{dd(\Illuminate\Support\Facades\Auth::guard('admin')->user())}}--}}

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
</script>
</body>
</html>
