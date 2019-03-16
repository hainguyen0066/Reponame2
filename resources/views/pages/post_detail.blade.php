@extends('layouts.front')
@php
$activeSlug = $post->getCategorySlug();
/** @var \App\Models\Post $post */
@endphp
@section('content')
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">{{ $post->title }}</p>
            {{ Breadcrumbs::render('post', $post) }}
        </div>
        <div class="main-details-content">
            {!! $post->body !!}
            <div class="ps">Võ Lâm Trung Nguyên <br>Kính Bút!</div>
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
