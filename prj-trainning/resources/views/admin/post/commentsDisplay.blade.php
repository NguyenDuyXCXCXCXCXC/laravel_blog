@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <div class="">
            <div class="border row ">
                <div class="col-2 border-right">
                    @if($comment->user->avatar == null || $comment->user->avatar == '')
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVhcVcxgW8LzmIu36MCeJb81AHXlI8CwikrHNh5vzY8A&s" alt="Avatar" class="avatar" style="display: block;">
                    @else
                        <img src="/image/{{$comment->user->avatar}}" alt="Avatar" class="avatar" style="display: block;">
                    @endif
                    <strong>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong>
                </div>
{{--                <div class="col-9">--}}
{{--                    <p>{{ $comment->comment }}</p>--}}
{{--                </div>--}}

                <textarea disabled class="col-10">{{ $comment->comment }}</textarea>
                <a href="" id="reply"></a>
            </div>
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <p style="margin-bottom: 0px;">{{ $comment->comment_time }}</p>
                    @if ($comment->status == 0)
                        <div class="d-flex">
{{--                            <button type="button" id="target" data-selected="true" value = "{{$comment->id}}" class="btn btn-danger btl-active">Chưa phê duyệt</button>--}}
                            <p type=""  class="bg-danger rounded p-1 mr-1">Chưa phê duyệt</p>
                            <a href="{{route('admin.comment.active', $comment->id)}}"><button type="button" id="target" data-selected="true" value = "{{$comment->id}}" class="btn btn-primary btl-active">Active</button></a>
                        </div>
                    @elseif($comment->status == 1)
                        <div class="pb-2">
                            <span type=""  class="bg-success rounded p-1">Đã phê duyệt</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        @include('admin.post.commentsDisplay', ['comments' => $comment->replies])
    </div>
@endforeach
