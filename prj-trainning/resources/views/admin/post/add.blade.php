@extends('admin.main')
@section('content')
    <div class="container-fluid">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / <a href="{{route('admin.post.list')}}">Posts</a> / Add</label>
    </div>
    @include('admin.users.alert')
    <div class="container">
        @include('admin.alert')
        <p class="bg-info" style="width: 108px;height: 25px;">Thêm bài viết</p>
        <form action="{{route('admin.post.store')}}" method="post" id="myForm" enctype="multipart/form-data">

            <div class="form-group" >
                <div style="display: flex;">
                    <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}" placeholder="Nhập tiêu đề bài viết">
                </div>
            </div>
            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 200px;padding-top: 6px;">Tiêu đề<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết">
                </div>
                @if ($errors->has('title'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('title') }}</p>
                @endif
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 200px;padding-top: 6px;">Chọn danh mục<span style="color: red;">*</span></label>
                    <select class="form-control form-select" name="categories_id" aria-label="Default select example">
                        <option value="">Lựa chọn danh sách danh mục</option>
                        @foreach($categories as $ca)
                            <option value="{{$ca->id}}" {{ old('categories_id') ==  $ca->id ? 'selected' : ''}}>{{$ca->name}}  </option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('categories_id'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('categories_id') }}</p>
                @endif
            </div>

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 200px;padding-top: 6px;">Hình ảnh bài viết<span style="color: red;">*</span></label>
                    <input type="file" name="photo" class="form-control" id="photo" placeholder="image">
                </div>
                @if ($errors->has('photo'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('photo') }}</p>
                @endif
            </div>
            <div class="input-group  mb-3" id="upload_file">
                {{--                    <img id="preview-image-before-upload" src="https://www.w3schools.com/tags/img_girl.jpg" alt="" width="50" height="60">--}}
            </div>


            <div>
                <div class="input-group  mb-3">
                    <label style="width: 145px;margin-right: 8px;">Trạng thái nổi bật<span style="color: red;">*</span></label>
                    <div class="form-group" style="margin-left: 18px;display: flex;">
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="1" {{ old('hot_flag') === "1" ? 'checked' : '' }} name="hot_flag" >
                            <label class="form-check-label">active</label>
                        </div>
                        <div class="form-check" style=" margin-right: 5px;">
                            <input class="form-check-input" type="radio" value="0" {{ old('hot_flag') === "0" ? 'checked' : '' }} name="hot_flag">
                            <label class="form-check-label">inactive</label>
                        </div>
                    </div>
                </div>
                @if ($errors->has('hot_flag'))
                    <p class="text-danger ml-3" style="font-size: 12px;">{{ $errors->first('hot_flag') }}</p>
                @endif
            </div>


            <div class="form-group" >
                <div >
                    <label style="width: 200px;padding-top: 6px;">Nội dung bài viết<span style="color: red;">*</span></label>
                    <textarea name="content">{{old('content')}}</textarea>
                </div>
                @if ($errors->has('content'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('content') }}</p>
                @endif
            </div>

            <div class="row pb-2">
                <!-- /.col -->
                <div class="col-2">
                    <button type="submit" class="btn btn-success btn-block">Hoàn thành</button>
                </div>
                <!-- /.col -->
                <div class="col-8"></div>
                <div class="col-2">
                    <a href="{{route('admin.post.list')}}" ><button type="button" class="btn btn-primary btn-block">Danh sách Bài viết</button></a>
                </div>
            </div>

            @csrf
        </form>

    </div>

    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        $('#photo').change(function(){

            $('#upload_file').empty();
            $('#upload_file').prepend('<img id="preview-photo-before-upload" src="" class="ml-4"  alt="image-preview" width="50" height="60"/>');
            let reader = new FileReader();

            reader.onload = (e) => {

                $('#preview-photo-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
