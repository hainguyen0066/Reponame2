@extends('layouts.front')
@php
    $pageTitle = "Đổi mật khẩu cấp 1";
@endphp
@section('content')
<div class="columns-right">
    <div class="details-content">
        @include('partials.manage_account.breadcrumbs')
        <div class="main-details-content">                                
            <div class="manage-account">
                <div class="features">
                    <div class="title">Đổi mật khẩu cấp 1</div>
                    <form method="POST" action="{{ route('front.password.change.submit') }}">
                        @csrf
                        <label for="old_password">Mật khẩu cấp 1 cũ</label>
                        <input type="password" name="old_password" id="old_password">
                        @if ($errors->has('old_password'))
                        <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                        </div>
                        @endif
                        <label for="password">Mật khẩu cấp 1 mới</label>
                        <input type="password" name="password" id="password">
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                        @endif
                        <label for="password_confirmation">Nhập lại mật khẩu cấp 1 mới</label>
                        <input type="password" name="password_confirmation" id="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <button type="submit" value="">Cập nhật</button>
                    </form>
                </div>
                @include('partials.manage_account.links_list')
            </div>
        </div>
    </div>
</div>
@endsection
