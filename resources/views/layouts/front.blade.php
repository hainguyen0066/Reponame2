<!DOCTYPE html>
<html>
<head>
    @component('meta')
        @slot('title')
            @section('title'){{ $title ?? config('site.seo.title') }}@show
        @endslot
        @slot('meta_description')
            {{ $meta_description ?? config('site.seo.meta_description') }}
        @endslot
        @slot('meta_keyword')
            {{ $meta_keyword ?? config('site.seo.meta_keyword') }}
        @endslot
    @endcomponent
    @include('partials.styles')
    @include('partials.tracker.google_tag_manager_partner.blade.php')
</head>
<body>
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
