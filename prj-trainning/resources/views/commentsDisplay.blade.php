@foreach($comments as $comment)
    @if( $comment->status == 1)
        <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
            <div class="">
                <div class="border row ">
                    <div class="col-2 border-right">
                        @if($comment->user->avatar == null || $comment->user->avatar == '')
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVhcVcxgW8LzmIu36MCeJb81AHXlI8CwikrHNh5vzY8A&s" alt="Avatar" class="avatar" style="display: block;">
                        @else
                            <img src="/image/{{$comment->user->avatar}}" alt="Avatar" class="avatar" style="display: block;">
                        @endif

                        @if(Auth::user() != null && ($comment->user->id == Auth::user()->id))
                            Bạn
                        @else
                            <strong>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong>
                        @endif
                    </div>
                    <textarea disabled class="col-10">{{ $comment->comment }}</textarea>
                    <a href="" id="reply"></a>
                </div>
                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <p style="margin-bottom: 0px;">{{ $comment->comment_time }}</p>
                        <div class="form" style="display: flex">
                            <div class="form-group mr-1">
                                {{--                            <input type="text" name="body" class="form-control" />--}}
                                <textarea name="comment" id="comment{{$comment->id}}"></textarea>
                                <input type="hidden" id="post_id{{$comment->id}}" name="post_id"  value="{{ $post_id }}" />
                                <input type="hidden" id="parent_id{{$comment->id}}" name="parent_id" value="{{ $comment->id }}" />
                            </div>
                            <div class="form-group">
                                @if(Auth::user() == null)
                                   <input type="submit"class="btn btn-warning" value="Bình luận" onclick="alertLoginToComment()" />
                                @else
                                    <input type="submit" id="butsave{{$comment->id}}" onclick="addComment({{$comment->id}})"  class="btn btn-warning" value="Bình luận" />
                                @endif

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="display-comment" id="cmt{{$comment->id}}" style="margin-left:40px;" >
            </div>
            @include('commentsDisplay', ['comments' => $comment->replies])
        </div>

    @elseif(Auth::user() != null && ($comment->user->id == Auth::user()->id) && $comment->status == 0  )
        <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>

            <div class="">
                <div class="border row ">
                    <div class="col-2 border-right">
                        @if($comment->user->avatar == null || $comment->user->avatar == '')
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVhcVcxgW8LzmIu36MCeJb81AHXlI8CwikrHNh5vzY8A&s" alt="Avatar" class="avatar" style="display: block;">
                        @else
                            <img src="/image/{{$comment->user->avatar}}" alt="Avatar" class="avatar" style="display: block;">
                        @endif

                        @if(Auth::user() != null && ($comment->user->id == Auth::user()->id))
                            Bạn
                        @else
                            <strong>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong>
                        @endif
                    </div>
                    <textarea disabled class="col-10">{{ $comment->comment }}</textarea>
                    <a href="" id="reply"></a>
                </div>
                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                            <p style="margin-bottom: 0px;"><span class="bg-danger">Chờ phê duyệt</span> {{ $comment->comment_time }}</p>
                        <div class="form" style="display: flex">
                            <div class="form-group mr-1">
                                {{--                            <input type="text" name="body" class="form-control" />--}}
                                <textarea name="comment" id="comment{{$comment->id}}"></textarea>
                                <input type="hidden" id="post_id{{$comment->id}}" name="post_id"  value="{{ $post_id }}" />
                                <input type="hidden" id="parent_id{{$comment->id}}" name="parent_id" value="{{ $comment->id }}" />
                            </div>
                            <div class="form-group">
                                @if(Auth::user() == null)
                                    <input type="submit"class="btn btn-warning" value="Bình luận" onclick="alertLoginToComment()" />
                                @else
                                    <input type="submit" id="butsave{{$comment->id}}" onclick="addComment({{$comment->id}})"  class="btn btn-warning" value="Bình luận" />
                                @endif

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="display-comment" id="cmt{{$comment->id}}" style="margin-left:40px;" >
            </div>
            @include('commentsDisplay', ['comments' => $comment->replies])
        </div>
    @endif

@endforeach
