@extends('admin.main')

@section('content')
    @include('admin.alert')
    <div class="container-fluid">

        <div class="container mt-3 border">
            <div>
                <h2 class=" mr-3 pl-4 mt-3 bg-info rounded">
                    {{$post->title}}
                </h2>
                <p class="ml-3"> {{$post->post_time}} </p>

            </div>
            {!! $post->content !!}
        </div>
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <i>{{$post->user->first_name}} {{$post->user->last_name}}</i>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-2"></div>
            <div class="col-6"> <a href="{{route('admin.post.edit', $post->id)}}"><button type="button" class="btn btn-primary">Chỉnh sửa</button></a> </div>
            <div class="col-3"> <a href="{{route('admin.post.list')}}"> <button type="button" class="btn btn-info">Danh sách Bài viết</button></a></div>
        </div>
    </div>
@endsection
