@extends('main')
@section('content')
    <div class="container">
        <h2 class="text-center">Hồ Sơ</h2>
        @include('alert')
        <form action="" method="post" id="myForm" >

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly >
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Họ và tên</label>
                    <input type="text" class="form-control"  value="{{ $user->first_name }} {{ $user->last_name }}" readonly >
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Giới tính</label>
                    <input type="text" class="form-control" value="{{  ($user->sex == 0 ? 'Nam' : 'Nữ') }}" readonly >
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Ngày sinh</label>
                    <input type="date" class="form-control" id="start" name="birthday" readonly value="{{ $user->birthday }}" min="1900-01-01" >
                </div>
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Avatar</label>
                    @if($user->avatar != null)
                        <img id="preview-image-before-upload" src="/image/{{$user->avatar}}" alt="Ava" class="avatar">
                    @else
                        <p class="text-center">Chưa có ảnh</p>
                    @endif
                </div>
            </div>


            @csrf
        </form>
        <div class="row pb-2">
            <div class="col-8"></div>
            <div class="col-2">
                <a href="{{route('client.profile.edit')}}">
                    <button type="button" class="btn btn-primary">Chỉnh sửa</button>
                </a>
            </div>
        </div>
    </div>
    <script>
        if( $(".alert").text() != ''){
            setTimeout(() =>{
                $(".alert").removeClass('alert alert-danger alert-success').text('')
            }, 5000);
        }
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
