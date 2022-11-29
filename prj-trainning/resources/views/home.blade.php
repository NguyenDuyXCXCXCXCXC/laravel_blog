@extends('main')
@section('content')

{{--tin tuc noi bat trong ngay --}}
    <div class="container border mt-3">
        <h4 class="my-title">Tin Tức Nổi Bật Trong Ngày</h4>
        <div class="row" style="min-height: 400px" id="posts">
            @foreach($postsActive as $postAc)
            <div class="col-6 mt-3">
                <article class="my-article">
                    <div class="article-left">
                        <img src="/image/{{$postAc->photo}}" alt="ảnh"/>
                    </div>
                    <div class="article-right">
                        <a href="#" class="text-decoration-none"> <h5 class="article-title">{{$postAc->title}}</h5></a>
                        <div class="article-content">{!! \Illuminate\Support\Str::limit($postAc->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
{{--                        <p class="article-content">Kim Tơ Nam Mộc là loại cây gỗ quý hiếm, được định giá tới hàng nghìn tỷ đồng nhưng hầu như rất ít người dám trồng loại cây này.</p>--}}
                        <p class="article-time">{{$postAc->post_time}}</p>
                    </div>
                </article>
            </div>
            @endforeach

        </div>
        <p class="see-more load-more" id="see-more">xem thêm</p>
    </div>


{{--tin tuc trong ngay --}}
    <div class="container border mt-3">
        <h4 class="my-title">Tin Tức Trong Ngày</h4>
        <div class="row" style="min-height: 400px" id="posts">
            @foreach($posts as $post)
                <div class="col-6 mt-3">
                    <article class="my-article">
                        <div class="article-left">
                            <img src="/image/{{$post->photo}}" alt="ảnh"/>
                        </div>
                        <div class="article-right">
                            <a href="#" class="text-decoration-none"> <h5 class="article-title">{{$post->title}}</h5></a>
                            <div class="article-content">{!! \Illuminate\Support\Str::limit($post->content, 80, $end = '...') !!}<a href="#"  style="font-size: 11px;" class="text-danger">xem thêm </a></div>
                            {{--                        <p class="article-content">Kim Tơ Nam Mộc là loại cây gỗ quý hiếm, được định giá tới hàng nghìn tỷ đồng nhưng hầu như rất ít người dám trồng loại cây này.</p>--}}
                            <p class="article-time">{{$post->post_time}}</p>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
        <p class="see-more load-more" id="see-more">xem thêm</p>
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

