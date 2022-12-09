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
                <div class="form" >
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
                                @if(Auth::user() == null)
                                    <input type="submit" class="btn btn-success" onclick="alertLoginToComment()" value="Hoàn thành" />
                                @else
                                    <input type="submit" class="btn btn-success" id="{{$idParent}}" onclick="addComment({{$idParent}})"   value="Hoàn thành" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="comment-zone">
                        @include('commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
                    </div>
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

        function alertLoginToComment()
        {
            if (confirm("Đăng nhập để bình luận!")){
                window.location.href = "{{route('client.login')}}?slug_post={{$post->slug}}";
            }

        }


        function appearFromReply(id){
            $(`#form${id}`).css('display', 'flex');
            $(`#reply${id}`).css('display', 'none');
        }

        function addComment(id){

            // tgian khi them cmt moi
            const dt = new Date();
            const padL = (nr, len = 2, chr = `0`) => `${nr}`.padStart(2, chr);
            timeFormat = `  ${dt.getFullYear()}-${padL(dt.getMonth()+1)}-${padL(dt.getDate())}
            ${padL(dt.getHours())}:${padL(dt.getMinutes())}:${padL(dt.getSeconds())}   `;

            // lay cac value khi them moi cmt
            if(id == 0){
                parentId = null;
            }else {
                parentId = document.getElementById('parent_id'+id).value;
            }
            comment = document.getElementById('comment' +id).value;
            postId = document.getElementById('post_id'+id).value;
            zoneCommentParrent = document.getElementById('comment-zone');


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
                    success: function(comment){

                        // lay gia tri comment xuat ra html
                        console.log(comment);
                            let html = `<div class="">
                            <div class="border row ">
                                <div class="col-2 border-right">
                                @if(Auth::user() != null && (Auth::user()->avatar == null || Auth::user()->avatar == ''))
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVhcVcxgW8LzmIu36MCeJb81AHXlI8CwikrHNh5vzY8A&s" alt="Avatar" class="avatar" style="display: block;">
                                @elseif(Auth::user() != null )
                                <img src="/image/{{ Auth::user()->avatar}}" alt="Avatar" class="avatar" style="display: block;">
                                @endif

                                 Bạn
                        </div>
                            <textarea disabled class="col-10">${comment.comment}</textarea>
                            <a href="" id="reply"></a>
                        </div>
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-5">
                                    <p style="margin-bottom: 0px;"><span class="bg-danger">Chờ phê duyệt</span> ${timeFormat}</p>
                                    <div class="form" style="display: flex">
                                        <div class="form-group mr-1">
                                {{--                            <input type="text" name="body" class="form-control" />--}}
                                <textarea name="comment" id="comment${comment.id}"></textarea>
                                            <input type="hidden" id="post_id${comment.id}" name="post_id"  value="${comment.post_id}" />
                                            <input type="hidden" id="parent_id${comment.id}" name="parent_id" value="${comment.id}" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit"  onclick="addComment(${comment.id})"  class="btn btn-warning" value="Bình luận" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                            <div class="display-comment" id="cmt${comment.id}" style="margin-left:40px;" >
                            </div>`;


                        if(comment.parent_id == null){
                            $('#comment-zone').prepend(html);// voi cmt la cmt dau tien
                        }
                        else {
                            $(`#cmt${id}`).append(html); // voi cmt la cmt thu n
                        }

                        // console.log(comment.comment)
                        // if(results == true){
                        //     location.reload();
                        // }else {
                        //     alert('Lỗi ko comment được!');
                        // }

                        document.getElementById('comment' +id).value = '';
                    }
                });
            }
        }
    </script>
@endsection

