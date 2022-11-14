
<!DOCTYPE html>
<html lang="en">
<head>


@include('admin.users.layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Admin Login</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            @include('admin.users.alert')
            <form action="/admin/login/store" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Dang nhap</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <a href="{{ route('admin.register') }}" class="text-center">
                            <button type="button" class="btn btn-success btn-block">Dang ky</button>
                        </a>
                    </div>
                    <!-- /.col -->
                </div>
                @csrf
            </form>


            <!-- /.social-auth-links -->

            <p class="mb-1 text-center">
                <a href="{{ route('admin.forgot-password') }}">Quen mat khau?</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->


@include('admin.users.layouts.footer')
</body>
</html>
