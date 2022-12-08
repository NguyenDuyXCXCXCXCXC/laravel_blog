@extends('main')
@section('content')

    {{--tin tuc noi bat trong ngay --}}
    <div class="container border mt-3">
        <h4 class="my-title">Tin Tức Nổi Bật Trong Ngày</h4>
        <div class="row"  id="posts">
            @foreach($posts as $post)
                <div class="col-6 mt-3">
                    <article class="my-article mb-2">
                        <div class="article-left">
                            <img src="/image/{{$post->photo}}" alt="ảnh"/>
                        </div>
                        <div class="article-right">
                            <a href="{{route('client.post.detail', $post->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$post->title}}</h5></a>
                            <div class="article-content">{!! \Illuminate\Support\Str::limit($post->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                            <p class="article-time">{{$post->post_time}}</p>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>

    </div>

    <div class="row mt-2">
        <div class="col-10"></div>
        <div class="col-1">{{ $posts->links() }}</div>
    </div>



@endsection

