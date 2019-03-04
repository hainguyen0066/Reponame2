@extends('layouts.front')
@section('content')
    <div class="content-detail">
        <div class="ctdt-header">
            {{ Breadcrumbs::render('search') }}
        </div>
        @include('partials.categories_list')
        @include('partials.search')
        @if(count($posts))
            @include('partials.posts_list')
        @else
            <div class="no-result">Không tìm thấy kết quả nào phù hợp!</div>
        @endif
    </div>
@endsection
