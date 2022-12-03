@extends('main')
@section('content')
    <h2 class="text-center mt-3">Đổi PassWord</h2>
    <div class="container mt-3 mb-3">
        @include('alert')
        <form action="{{route('client.profile.updatePassword')}}" method="post" id="myForm" >

            <div class="form-group" >
                <div style="display: flex;">
                    <input type="hidden" class="form-control" name="id_user_changepass" value="{{$id}}">
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 103px;padding-top: 0px;">Mật khẩu cũ<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password_old" id="password-field" placeholder="Nhập mật khẩu cũ">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
                </div>
                @if (\Illuminate\Support\Facades\Session::has('myError'))
                    <p class="text-danger text-center" style="font-size: 12px;">
                        {{ \Illuminate\Support\Facades\Session::get('myError') }}
                    </p>
                @endif
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 103px;padding-top: 0px;">Mật khẩu<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password" id="password-field2" placeholder="Nhập mật khẩu ">
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
                    <label style="width: 101px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" id="password-field3" placeholder="Nhập mật khẩu confirm ">
                    <span toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password3" style="
                                                                                    float: right;
                                                                                    margin-left: -21px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>
                </div>
                @if ($errors->has('password_confirmation'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>


            <div class="row pb-2">
                <!-- /.col -->
                <div class="col-2">
                    <button type="submit" class="btn btn-success btn-block">Hoàn thành</button>
                </div>
                <!-- /.col -->
                <div class="col-2"></div>
                <div class="col-6"></div>
                <div class="col-2">
                    <a href="{{route('client.profile.edit')}}" ><button type="button" class="btn btn-primary btn-block">Quay lại</button></a>
                </div>
            </div>
            @csrf
        </form>

    </div>

    <script>

        // show hide password
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

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
    </script>
@endsection
