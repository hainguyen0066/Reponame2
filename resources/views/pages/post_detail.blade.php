@extends('layouts.front')
@php
$activeSlug = $post->getCategorySlug();
/** @var \T2G\Common\Models\Post $post */
@endphp
@section('content')
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">{{ $post->title }}</p>
            {{ Breadcrumbs::render('post', $post) }}
        </div>
        <div class="main-details-content">
            <div class="post-body">
                {!! $post->body !!}
            </div>
            <div class="ps">
                <img src="{{ asset('images/ps-icon.png') }}" alt="" height="20" width="20">
                &nbsp; Võ Lâm Trung Nguyên &nbsp;
                <img src="{{ asset('images/ps-icon.png') }}" alt="" height="20" width="20"><br/>
                Kính Bút!
            </div>
            @if(count($others))
                <div class="view-more">
                    <ul>
                        @foreach($others as $other)
                            <li>
                                <a href="{{ route('front.details.post', [$other->getCategorySlug(), $other->slug]) }}">
                                    {{ str_limit($other->title, 100) }} <span>{{ $other->displayPublishedDate() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('schemas')
    @include('t2g_common::schemas.post')
@endpush
