@extends('layouts.front')

@section('content')
    @include('partials.slider')
    @include('partials.homepage.guides')
    @include('partials.homepage.news')
    @include('partials.homepage.newbies')
@endsection

@if(!empty($banner))
    @section('banner')
        @include('modal.banner')
    @endsection
@endif

