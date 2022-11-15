<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.users.layouts.head')
    <style>
        .form-check {
            margin-left: 15px;
        }
    </style>
</head>
<body class="hold-transition register-page">

<div class="container pt-5">
    <h3 class="text-center">Chúc mừng bạn đã đăng ký tài khoản thành công!</h3>
    <p class="text-center">Nhấp vào link sau để đăng nhập <a href="{{ route('admin.login') }}">Login</a> </p>
</div>

@include('admin.users.layouts.footer')
</body>
</html>
