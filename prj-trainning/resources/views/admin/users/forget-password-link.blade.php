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
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">

                    </div>

                    @if ($errors->has('password'))
                        <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 105px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Nhập mật khẩu confirm">
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
