@extends('admin.main')

@section('content')
    @include('admin.alert')
    <div class="container-fluid pt-2">
        <label class="pl-5"><a href="{{route('admin.dashboard')}}">Home</a>  / <a href="{{route('admin.comment.list')}}">Comments</a>/ Detail</label>
    </div>
    <div class="container">
        <table class="table table-bordered">
            <thead>
{{--            <tr>--}}
{{--                <th scope="col">#</th>--}}
{{--                <th scope="col">First</th>--}}
{{--                <th scope="col">Last</th>--}}
{{--                <th scope="col">Handle</th>--}}
{{--            </tr>--}}
            </thead>
            <tbody>
            <tr>
                <th scope="row">Bài viết</th>
                <td colspan="2">{{$comment->post->title}}</td>
            </tr>
            <tr>
                <th scope="row">Người comments</th>
                <td colspan="2">{{$comment->user->first_name}} {{ $comment->user->last_name}}</td>
            </tr>
            <tr>
                <th scope="row">Nội dung</th>
                <td colspan="2">
                    {{ $comment->comment}}
                </td>
            </tr>
            <tr scope="row">
                <td colspan="3">

                </td>

            </tr>
            </tbody>

        </table>
        <div class="row pt-3 pb-4">
            <div class="col-3">
                @if ($comment->status == 0)
                    <a href="{{route('admin.comment.active', $comment->id)}}"><button type="button" class="btn btn-success btl-active">Active</button></a>
                @endif
            </div>
            <div class="col-6"></div>
            <div class="col-3">
                @if ($comment->status == 1)
                    <a href="{{route('admin.comment.inactive', $comment->id)}}"><button type="button" class="btn btl-active" style="background-color: #ef2929b3;">InActive</button></a>
                @endif

            </div>
        </div>
        <div class="row pt-3 pb-4">
            <div class="col-3">
            </div>
            <div class="col-6"></div>
            <div class="col-3">
                <a href="{{route('admin.comment.destroy', $comment->id)}}"><button type="button" class="btn btn-danger btl-active" >Delete</button></a>
            </div>
        </div>
    </div>
@endsection
