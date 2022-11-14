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
<div class="register-box" style="width: 520px;">
    <div class="register-logo">
        <b>Dang ky tai khoan quan tri vien</b>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            @include('admin.users.alert')
            <form action="/admin/register/store" method="post" id="myForm">

                <div class="input-group mb-3">
                    <label style="width: 84px; padding-top: 6px;">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Nhap dia chi Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="input-group mb-3">
                            <label style="width: 84px; padding-top: 6px;">Ho</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Nhap ho ...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5" style="margin-left: 80px;">
                        <div class="input-group mb-3">
                            <label style="width: 60px; padding-top: 6px;">Ten</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Nhap ten ...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="input-group mb-3">
                    <label style="width: 84px; padding-top: 6px;">Mat khau</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhap mat khau">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <label style="width: 84px;">Xac thuc mat khau</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password">
                    <div class="input-group-append" style="height: 38px;">
                        <div class="input-group-text">
                        </div>
                    </div>
                </div>

                <div class="input-group  mb-3">
                    <label style="margin-right: 8px;">Gioi tinh</label>
                    <div class="form-group" style="display: flex;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="0" name="sex" checked="">
                            <label class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" name="sex">
                            <label class="form-check-label">Nu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="sex">
                            <label class="form-check-label">Khac</label>
                        </div>
                    </div>
                </div>

                <div class="input-group  mb-3">
{{--                    <div class="form-group">--}}
                        <label style="width: 84px; padding-top: 6px;">Dia chi</label>
                        <textarea class="form-control" rows="1" cols="60" name="address" placeholder="Nhap dia chi ..."></textarea>
{{--                    </div>--}}
                </div>

                <div class="row">
                    <!-- /.col -->
                    <div class="col-6">
                        <button type="submit" class="btn btn-success btn-block">Dang ky</button>
                    </div>
                    <!-- /.col -->

                    <div class="col-6">
                        <a href="{{ route('admin.login') }}" ><button type="button" class="btn btn-primary btn-block">Dang nhap</button></a>
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
    $('#myForm').submit(function(){
        if($('[name=password]').val() != $('#confirm_password').val()){
            alert("Password does not match Confirm password!");
            return false;
        }
        return true;
    })
</script>
</body>
</html>
