<div class="columns-left">
    @include('partials.sidebar.download_button')
    @include('partials.sidebar.account_box')
    {{--@include('partials.sidebar.search')--}}    
    @include('partials.sidebar.hotline')
    @include('partials.sidebar.activity')
    @if(Route::currentRouteName() != 'front.home')
        @include('partials.sidebar.supports')
    @endif
    @include('partials.fb_fanpage')
</div>
