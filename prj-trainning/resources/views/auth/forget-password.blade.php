<!DOCTYPE html>
<html lang="en">
<head>
    @include('auth.layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h4>Quên mật khẩu</h4>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Vui lòng nhập email của bạn để nhận mật khẩu mới.</p>
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <form action="" method="post">
                @csrf
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="padding-top: 6px; padding-right: 5px">Địa chỉ mail<span style="color: red;">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ mail">
                    </div>
                    @if ($errors->has('email'))
                        <span class="text-danger text-center">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Hoàn thành</button>
                    </div>
                    <div class="col-6">
                        <a href="" ><button type="button" class="btn btn-danger btn-block">Đăng nhập</button></a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

@include('auth.layouts.footer')
</body>
</html>
