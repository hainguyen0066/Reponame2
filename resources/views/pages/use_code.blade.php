@extends('layouts.front')

@section('content')
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">{{ $page->title }}</p>
            {{ Breadcrumbs::render('afterHome', 'Nhập Code') }}
        </div>
        <div class="main-details-content">
            @if(\Auth::check())
                <form method="POST" action="{{ route('front.gift_code.use_code') }}" id="gift-code-form">
                    @csrf
                    <div class="gift-code-input-row">
                        <input type="text" name="code" id="code" value="{{ old('code') }}"/>
                        <button type="submit" value="">OK</button>
                    </div>
                    @if ($errors->has('code'))
                        <div class="alert alert-error" role="alert">
                            <span role="alert">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif
                </form>
            @else
                <div class="text-center">Vui lòng <a href="javascript:" class="account-login">đăng nhập</a> để nhận Gift Code</div>
            @endif
            <br class="clearfix">
            <div class="post-body">
                {!! $page->body !!}
            </div>
        </div>
    </div>
@endsection
