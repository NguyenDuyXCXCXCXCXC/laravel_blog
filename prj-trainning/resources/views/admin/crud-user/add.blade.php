@extends('admin.main')
@section('content')
    <div class="container-fluid">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / <a href="{{route('admin.user.list')}}">Users</a> / Add</label>
    </div>
    @include('admin.users.alert')
    <div class="container">
        @include('admin.alert')
         <p class="bg-info" style="width: 108px;height: 25px;">Thêm mới user</p>
        <form action="{{route('admin.user.store')}}" method="post" id="myForm" enctype="multipart/form-data">

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;"">Email<span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ mail">
                </div>
                @if ($errors->has('email'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="form-group" >
                <div class="row" style="display: flex;">
                    <div class="col-5">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 118px;padding-top: 6px;">Họ<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Nhập họ">
                            </div>
                            @if ($errors->has('first_name'))
                                <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('first_name') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-5" style="margin-left: 188px;">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 60px; padding-top: 6px;">Tên<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Nhập tên">
                            </div>
                            @if ($errors->has('last_name'))
                                <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('last_name') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 103px;padding-top: 0px;">Mật khẩu<span style="color: red;">*</span></label>
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
                        <label style="width: 101px;">Mật khẩu confirm<span style="color: red;">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Nhập mật khẩu confirm ">
                        <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password3" style="
                                                                                    float: right;
                                                                                    margin-left: -25px;
                                                                                    margin-top: 11px;
                                                                                    position: relative;
                                                                                    z-index: 2;"></span>

                    </div>
                    @if ($errors->has('password_confirmation'))
                        <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="input-group  mb-3">
                    <label style="margin-right: 8px;">Giới tính<span style="color: red;">*</span></label>
                    <div class="form-group" style="margin-left: 18px;display: flex;">
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="0" name="sex" checked="">
                            <label class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="1" name="sex">
                            <label class="form-check-label">Nữ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="sex">
                            <label class="form-check-label">Khác</label>
                        </div>
                    </div>
                </div>

                <div class="input-group  mb-3">
                    <label style="width: 91px;padding-top: 6px;">Ngày sinh</label>
                    <input type="date" class="form-control" id="start" name="birthday" min="1900-01-01" >
                </div>

                <div class="input-group  mb-3">
                    <label style="width: 91px;padding-top: 6px;">Địa chỉ</label>
                    <textarea class="form-control" rows="1" cols="60" name="address"  placeholder="Nhập đia chỉ ..."> {{ old('address') }}</textarea>
                </div>

                <div>
                    @if (($user->role) === 1)
                        <div class="">
                                <input class="form-check-input" type="hidden" value="2" name="role" >
                        </div>
                    @elseif (($user->role) === 3)
                        <div class="input-group  mb-3">

                            <label style="margin-right: 8px;">Vai trò<span style="color: red;">*</span></label>

                            <div class="form-group" style="margin-left: 18px;display: flex;">
                                <div class="form-check" style=" margin-right: 5px;">
                                    <input class="form-check-input" type="radio" value="3" name="role" >
                                    <label class="form-check-label">Manager</label>
                                </div>
                                <div class="form-check" style=" margin-right: 5px;">
                                    <input class="form-check-input" type="radio" value="1" name="role">
                                    <label class="form-check-label">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="2" name="role" checked="">
                                    <label class="form-check-label">Users</label>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>

                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 91px;padding-top: 6px;">Avatar</label>
                        <input type="file" name="avatar" class="form-control" id="avatar" placeholder="image">
                    </div>
                    @if ($errors->has('avatar'))
                        <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('avatar') }}</p>
                    @endif
                </div>

                <div class="input-group  mb-3" id="upload_file">
{{--                    <img id="preview-image-before-upload" src="https://www.w3schools.com/tags/img_girl.jpg" alt="" width="50" height="60">--}}
                </div>


                <div class="row pb-2">
                    <!-- /.col -->
                    <div class="col-2">
                        <button type="submit" class="btn btn-success btn-block">Hoàn thành</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-8"></div>
                    <div class="col-2">

                        @if (($user->role) === 1)
                            <a href="{{route('admin.user.listForUser')}}" ><button type="button" class="btn btn-primary btn-block">Danh sách Users</button></a>
                        @elseif (($user->role) === 3)
                            <a href="{{route('admin.user.list')}}" ><button type="button" class="btn btn-primary btn-block">Danh sách Users</button></a>
                        @endif
                    </div>
                </div>
            @csrf
    </form>

    </div>

    <script>
        $('#avatar').change(function(){

            $('#upload_file').empty();
            $('#upload_file').prepend('<img id="preview-avatar-before-upload" src=""  alt="image-preview" width="50" height="60"/>');
            let reader = new FileReader();

            reader.onload = (e) => {

                $('#preview-avatar-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        });


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
    </script>
@endsection
