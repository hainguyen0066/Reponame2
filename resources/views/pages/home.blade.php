@extends('layouts.front')

@section('content')
    @include('partials.slider')
    @include('partials.homepage.guides')
    @include('partials.homepage.news')
    @include('partials.homepage.newbies')    
@endsection
@if(!empty($banners[0]))
    @section('banner')
        @include('modal.banner')
    @endsection
@endif

