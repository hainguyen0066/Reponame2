@extends('layouts.front')
@section('content')
    @php
        $activeSlug = $category->slug;
    @endphp
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">{{ $category->name }}</p>
            {{ Breadcrumbs::render('category', $category) }}
        </div>
        <div class="main-details-content">
            @include('partials.categories_list')
            @include('partials.posts_list')
        </div>
    </div>
@endsection


