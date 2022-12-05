@extends('main')
@section('content')
    @php
    $idParent = '0';
    @endphp
<div>
    <div class="container bg-light">
        <div class="row">
            <div class="col-9 pl-4 pt-2">
                <div class="border-right">
                    <h2 >
                        {{$post->title}}
                    </h2>
                    <div>
                        <p class=""> {{$post->post_time}} </p>
                    </div>

                    {!! $post->content !!}
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4 font-weight-bold">
                        <i>{{$post->user->first_name}} {{$post->user->last_name}}</i>
                    </div>
                </div>
                <h4>Bình luận</h4>
                <hr />
                <div class="form" id="comment-zone">
                    <div class="form-group">
                        <textarea class="form-control" name="comment" id="comment{{$idParent}}" placeholder="Viết comments . . . "></textarea>
                        @if ($errors->has('comment'))
                            <p class="text-danger text-center" style="font-size: 12px;">{{ $errors->first('comment') }}</p>
                        @endif
                        <input type="hidden" name="post_id" id="post_id{{$idParent}}" value="{{ $post->id }}" />
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <input type="submit" class="btn btn-success" id="{{$idParent}}" onclick="addComment({{$idParent}})"  value="Hoàn thành" />
                            </div>
                        </div>
                    </div>
                    @include('commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
                </div>
                <hr />
            </div>
            <div class="col-3 pt-2">
                <h2>Tin tức liên quan</h2>
                @foreach($postRandom as $postR)
                    <article class="my-article" style=" width: 312px;">
                        <div class="article-left">
                            <a href="{{route('client.post.detail', $postR->slug)}}">
                                <img src="/image/{{$postR->photo}}" alt="ảnh"/>
                            </a>
                        </div>
                        <div class="article-right">
                            <a href="{{route('client.post.detail', $postR->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$postR->title}}</h5></a>
                            <p class="article-time">{{$postR->post_time}}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</div>
    <script>
        function addComment(id){
            if(id == 0){
                parentId = null;
            }else {
                parentId = document.getElementById('parent_id'+id).value;
            }
            comment = document.getElementById('comment' +id).value;
            postId = document.getElementById('post_id'+id).value;

            if(comment != ""){
                $.ajax({
                    url: "{{route('client.post.comment')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        parent_id: parentId,
                        comment: comment,
                        post_id: postId,
                    },
                    success: function(results){
                        if(results == true){
                            location.reload();
                        }else {
                            alert('Lỗi ko comment được!');
                        }

                    }
                });
            }
        }
    </script>
@endsection

