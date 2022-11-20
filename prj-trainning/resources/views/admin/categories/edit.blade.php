@extends('admin.main')
@section('content')
    <div class="container-fluid">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / <a href="{{route('admin.categories.list')}}">Categories </a> / Edit </label>
    </div>
    @include('admin.users.alert')
    <div class="container">
        @include('admin.alert')
        <form action="{{route('admin.categories.update', $categories->id)}}" method="post" id="myForm">

            <div class="form-group" >
                <div style="display: flex;">
                    <label style="width: 102px;padding-top: 6px;">Danh mục <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="categories" value="{{$categories->name}}" placeholder="Nhập danh mục">
                </div>
                @if ($errors->has('categories'))
                    <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('categories') }}</p>
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
                    <a href="{{route('admin.categories.list')}}" ><button type="button" class="btn btn-primary btn-block">Danh sách Danh mục</button></a>
                </div>
            </div>

            @csrf
        </form>

    </div>


@endsection
