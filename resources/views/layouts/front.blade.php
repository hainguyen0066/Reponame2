<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=1920, initial-scale=1">
    @component('meta')
        @slot('title')
        @section('title'){{ $title ?? config('t2g_common.site.seo.title') }}@show
        @endslot
        @slot('meta_description')
            {{ $meta_description ?? config('t2g_common.site.seo.meta_description') }}
        @endslot
        @slot('meta_keywords')
            {{ $meta_keywords ?? config('t2g_common.site.seo.meta_keyword') }}
        @endslot
        @slot('meta_image')
            {{ $meta_image ?? asset(config('t2g_common.site.seo.meta_image')) }}
        @endslot
        @slot('og_type')
            {{ $og_type ?? 'website' }}
        @endslot
    @endcomponent
    @include('partials.styles')
</head>
<body class="tet">
@include('partials.trackers')
<div class="wrapper">
    @include('partials.header')
    <div class="main_content">
        <div class="container">
            <div class="slogan"></div>
            <div class="two-columns">
                @include('partials.sidebar')
                <div class="columns-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</div>
@if(!Auth::user())
    @include('modal.account')
@endif
@yield('banner')
@section('js')
    @include('partials.scripts')
@show
@include('partials.tracker.fb_chat')
</body>
</html>
