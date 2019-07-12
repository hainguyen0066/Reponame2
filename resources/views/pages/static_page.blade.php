@extends('layouts.front')

@section('content')
    @if(view()->exists('pages.static.' . $page->group))
        @include('pages.static.' . $page->group)
    @elseif(view()->exists('pages.static.' . $page->view))
        @include('pages.static.' . $page->view)
    @else
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">{{ $page->title }}</p>
            {{ Breadcrumbs::render('static', $page) }}
        </div>
        <div class="main-details-content">
            <div class="post-body">
                {!! $page->body !!}
            </div>
        </div>
    </div>
    @endif
@endsection
