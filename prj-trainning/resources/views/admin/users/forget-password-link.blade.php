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
        <div class="card-body">
            <form action="recover-password.html" method="post">
                <div class="input-group mb-3">
                    <label style="padding-top: 6px; padding-right: 5px">Mật khẩu<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Nhập mật khẩu">
                </div>
                <div class="input-group mb-3">
                    <label style="width: 77px;padding-right: 5px">Mật khẩu confirm<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Nhập mật khẩu confirm">
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
</body>
</html>
