@extends('layouts.front')

@section('content')
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">Tìm kiếm</p>
            {!! Breadcrumbs::render('search') !!}
        </div>
        <div class="main-details-content">
            @if(count($posts))
                <h3>Tìm thấy <i>{{ $posts->total() }}</i> kết quả với từ khóa "{{ request('search') }}"</h3>
                @include('partials.posts_list')
            @else
                <div class="no-result">Không tìm thấy kết quả nào phù hợp!</div>
            @endif
        </div>
    </div>
@endsection

