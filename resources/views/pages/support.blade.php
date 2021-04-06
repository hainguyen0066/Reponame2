@extends('layouts.front')

@section('content')
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">Hỗ trợ</p>
            {{ Breadcrumbs::render('afterHome', 'Hỗ trợ') }}
        </div>
        <div class="main-details-content">
            <div class="post-body">
                <iframe src="{{ $url }}" width="100%" height="700" frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endsection
