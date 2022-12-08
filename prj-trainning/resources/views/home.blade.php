@extends('main')
@section('content')

{{--tin tuc noi bat trong ngay --}}
    <div class="container border mt-3">
        <h4 class="my-title">Tin Tức Nổi Bật Trong Ngày</h4>
        <div class="row"  id="posts">
            @foreach($postsInDayActive as $postAc)
            <div class="col-6 mt-3">
                <article class="my-article mb-2">
                    <div class="article-left">
                        <a href="{{route('client.post.detail', $postAc->slug)}}">
                            <img src="/image/{{$postAc->photo}}" alt="ảnh"/>
                        </a>
                    </div>
                    <div class="article-right">
                        <a href="{{route('client.post.detail', $postAc->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$postAc->title}}</h5></a>
                        <div class="article-content">{!! \Illuminate\Support\Str::limit($postAc->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                        <p class="article-time">{{$postAc->post_time}}
                            &nbsp;  &nbsp;
                            <i class="text-info">
                                lượt xem:
                                @if($postAc->views == null)
                                    0
                                @else
                                    {{$postAc->views}}
                                @endif
                            </i>
                        </p>
                    </div>
                </article>
            </div>
            @endforeach

        </div>
{{--        <p class="see-more load-more" id="see-more">xem thêm</p>--}}
    </div>


{{--tin tuc trong ngay --}}
    <div class="container border mt-3">
        <h4 class="my-title">Tin Tức Trong Ngày</h4>
        <div class="row"  id="posts">
            @foreach($postsInDay as $post)
                <div class="col-6 mt-3">
                    <article class="my-article">
                        <div class="article-left">
                            <a href="{{route('client.post.detail', $post->slug)}}">
                                <img src="/image/{{$post->photo}}" alt="ảnh"/>
                            </a>
                        </div>
                        <div class="article-right">
                            <a href="{{route('client.post.detail', $post->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$post->title}}</h5></a>
                            <div class="article-content">{!! \Illuminate\Support\Str::limit($post->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                            <p class="article-time">{{$post->post_time}}
                                &nbsp;  &nbsp;
                                <i class="text-info">
                                    lượt xem:
                                    @if($post->views == null)
                                        0
                                    @else
                                        {{$post->views}}
                                    @endif
                                </i>
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
{{--        <p class="see-more load-more" id="see-more">xem thêm</p>--}}
    </div>




{{--tin tuc cua category dau tien --}}
<div class="container border mt-3">
    <h4 class="my-title">{{$categories[0]->name}}</h4>
    <div class="row"  id="posts">
        @foreach($postsByCategoryFirst as $postF)
            <div class="col-6 mt-3">
                <article class="my-article">
                    <div class="article-left">
                        <a href="{{route('client.post.detail', $postF->slug)}}">
                            <img src="/image/{{$postF->photo}}" alt="ảnh"/>
                        </a>
                    </div>
                    <div class="article-right">
                        <a href="{{route('client.post.detail', $postF->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$postF->title}}</h5></a>
                        <div class="article-content">{!! \Illuminate\Support\Str::limit($postF->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                        <p class="article-time">{{$postF->post_time}}
                            &nbsp;  &nbsp;
                            <i class="text-info">
                                lượt xem:
                                @if($postF->views == null)
                                    0
                                @else
                                    {{$postF->views}}
                                @endif
                            </i>
                        </p>
                    </div>
                </article>
            </div>
        @endforeach

    </div>
{{--    <p class="see-more load-more" id="see-more">xem thêm</p>--}}
</div>


{{--tin tuc cua category thu hai --}}
<div class="container border mt-3">
    <h4 class="my-title">{{$categories[1]->name}}</h4>
    <div class="row"  id="posts">
        @foreach($postsByCategorySecond as $postS)
            <div class="col-6 mt-3">
                <article class="my-article">
                    <div class="article-left">
                        <a href="{{route('client.post.detail', $postS->slug)}}">
                            <img src="/image/{{$postS->photo}}" alt="ảnh"/>
                        </a>
                    </div>
                    <div class="article-right">
                        <a href="{{route('client.post.detail', $postS->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$postS->title}}</h5></a>
                        <div class="article-content">{!! \Illuminate\Support\Str::limit($postS->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                        <p class="article-time">{{$postS->post_time}}
                            &nbsp;  &nbsp;
                            <i class="text-info">
                                lượt xem:
                                @if($postS->views == null)
                                    0
                                @else
                                    {{$postS->views}}
                                @endif
                            </i>
                        </p>
                    </div>
                </article>
            </div>
        @endforeach

    </div>
{{--    <p class="see-more load-more" id="see-more">xem thêm</p>--}}
</div>



{{--tin tuc cua category thu ba --}}
<div class="container border mt-3 mb-3">
    <h4 class="my-title">{{$categories[2]->name}}</h4>
    <div class="row"  id="posts">
        @foreach($postsByCategoryThird as $postT)
            <div class="col-6 mt-3">
                <article class="my-article">
                    <div class="article-left">
                        <a href="{{route('client.post.detail', $postT->slug)}}">
                            <img src="/image/{{$postT->photo}}" alt="ảnh"/>
                        </a>
                    </div>
                    <div class="article-right">
                        <a href="{{route('client.post.detail', $postT->slug)}}" class="text-decoration-none"> <h5 class="article-title">{{$postT->title}}</h5></a>
                        <div class="article-content">{!! \Illuminate\Support\Str::limit($postT->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                        <p class="article-time">
                            {{$postT->post_time}}
                            &nbsp;  &nbsp;
                            <i class="text-info">
                                lượt xem:
                                @if($postT->views == null)
                                    0
                                @else
                                    {{$postT->views}}
                                @endif
                            </i>
                        </p>
                    </div>
                </article>
            </div>
        @endforeach

    </div>
{{--    <p class="see-more load-more" id="see-more">xem thêm</p>--}}
</div>

<script>
    // $("#see-more").click(function() {
    //     $div = $($(this).data('div')); //div to append
    //     $link = $(this).data('link'); //current URL
    //
    //     $page = $(this).data('page'); //get the next page #
    //     $href = $link + $page; //complete URL
    //     $.get($href, function(response) { //append data
    //         $html = $(response).find("#posts").html();
    //         $div.append($html);
    //     });
    //
    //     $(this).data('page', (parseInt($page) + 1)); //update page #
    // });
</script>
@endsection

