@extends('layouts.front')

@section('content')
    <div class="details-content welcome">
        <div class="header-details-content">
            <h1><p class="c-white">Chào mừng thành viên mới</p></h1>
            {{ Breadcrumbs::render('afterHome', 'Chào mừng đến với ' . config('app.name')) }}
        </div>
        <div class="main-details-content auto">
            <div class="post-body">
                <h3><b>Chào mừng <span class="text-red">{{ $user->name }}</span> !!!</b></h3>
                <p class="mt10">Chúng tôi biết bạn có nhiều sự lựa chọn, cảm ơn bạn đã chọn đồng hành với <b>{{ config('app.name') }}</b>.</p>
                <p class="list-group mt10">Để bắt đầu, bạn có thể tham khảo các links sau đây:</p>
                <div class="news auto">
                    <div class="listnews">
                        <ul>
                            @foreach($welcomePosts as $k => $post)
                                <li>
                                    <a href="{{ route('front.details.post', [$post->getCategorySlug(), $post->slug]) }}"
                                       title="{{ $post->title }}"
                                    >
                                        {{ $post->title }}
                                    </a>
                                </li>
                                @if($k == 1)
                                    <li>
                                        <a href="{{ route('front.page.download') }}" title="Hướng dẫn tải & cài game">
                                            Hướng dẫn tải & cài game
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('front.details.post', ['tong-hop','thong-tin-sever-vo-lam-trung-nguyen']) }}" title="Hướng dẫn người chơi mới">
                                            Hướng dẫn người chơi mới
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <p class="list-group mt10">Hoặc cập nhật thông tin mới nhất:</p>
                <div class="news auto">
                    <div class="listnews">
                        <ul>
                            @foreach($newPosts as $post)
                                <li>
                                    <a href="{{ route('front.details.post', [$post->getCategorySlug(), $post->slug]) }}"
                                       title="{{ $post->title }}"
                                    >
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.homepage.guides')
    </div>
@endsection
@push('extra-js')
    <script>
        $(document).ready(() => document.getElementById('popupGiftCode').style.display = 'initial');
    </script>
@endpush
