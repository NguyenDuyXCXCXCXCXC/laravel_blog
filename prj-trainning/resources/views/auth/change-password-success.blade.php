<!DOCTYPE html>
<html lang="en">
<head>
    @include('auth.layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1><b>Thành viên</b></h1>
        </div>
        <div class="card-body">
            <p class="login-box-msg text-success">Thay đổi mật khẩu thành công !</p>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <a href="{{ route('client.login') }}" ><button type="button" class="btn btn-primary btn-block">Đăng nhập</button></a>
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

@include('auth.layouts.footer')
</body>
</html>
