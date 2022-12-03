@extends('main')
@section('content')
    @include('alert')
    <h2 class="text-center">Hồ Sơ</h2>
    <div class="container pt-3">
        <form action="{{route('client.profile.update')}}" method="post" id="myForm" enctype="multipart/form-data">

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Email<span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly placeholder="Nhập địa chỉ mail">
                </div>
            </div>

            <div class="form-group" >
                <div class="row" style="display: flex;">
                    <div class="col-5">
                        <div class="form-group" >
                            <div style="display: flex;">
                                <label style="width: 118px;padding-top: 6px;">Họ<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" placeholder="Nhập họ">
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
                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" placeholder="Nhập tên">
                            </div>
                            @if ($errors->has('last_name'))
                                <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('last_name') }}</p>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="input-group  mb-3">
                    <label style="margin-right: 8px;">Giới tính<span style="color: red;">*</span></label>
                    <div class="form-group" style="margin-left: 18px;display: flex;">
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="0" name="sex" {{  ($user->sex == 0 ? ' checked' : '') }}>
                            <label class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="1" name="sex" {{  ($user->sex == 1 ? ' checked' : '') }}>
                            <label class="form-check-label">Nữ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="sex" {{  ($user->sex == 2 ? ' checked' : '') }}>
                            <label class="form-check-label">Khác</label>
                        </div>
                    </div>
                </div>

                <div class="input-group  mb-3">
                    <label style="width: 91px;padding-top: 6px;">Ngày sinh</label>
                    <input type="date" class="form-control" id="start" name="birthday" value="{{ $user->birthday }}" min="1900-01-01" >
                </div>

                <div class="input-group  mb-3">
                    <label style="width: 91px;padding-top: 6px;">Địa chỉ</label>
                    <textarea class="form-control" rows="1" cols="60" name="address"  placeholder="Nhập đia chỉ ..."> {{ $user->address   }}</textarea>
                </div>



                <div class="form-group" >
                    <div style="display: flex;">
                        <label style="width: 91px;padding-top: 6px;">Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" placeholder="image">
                    </div>
                    @if ($errors->has('avatar'))
                        <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('avatar') }}</p>
                    @endif
                </div>

                <div class="input-group  mb-3" id="upload_file">
                    @if($user->avatar != null)
                        <img id="preview-image-before-upload" src="/image/{{$user->avatar}}" alt="Ava" class="avatar">
                    @else
                        <p class="text-center">Chưa có ảnh</p>
                    @endif

                    {{--                    <img src="https://www.w3schools.com/tags/img_girl.jpg" alt="Girl in a jacket" width="50" height="60">--}}
                </div>


                <div class="row pb-2">
                    <!-- /.col -->
                    <div class="col-2">
                        <button type="submit" class="btn btn-success btn-block">Hoàn thành</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-2">
                        <a href="{{route('client.profile.editPassword', $user->id)}}"> <button type="button" class="btn btn-info ">Thay đổi mật khẩu</button></a>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-2">
                        <a href="{{route('client.profile')}}" ><button type="button" class="btn btn-primary btn-block">Quay lại</button></a>
                    </div>
                </div>
            @csrf
        </form>

    </div>
    <script>

        // xem trc anh avatar
        $('#avatar').change(function(){

            $('#upload_file').empty();
            $('#upload_file').prepend('<img id="preview-avatar-before-upload" src=""  alt="image-preview" width="50" height="60"/>');
            let reader = new FileReader();

            reader.onload = (e) => {

                $('#preview-avatar-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
