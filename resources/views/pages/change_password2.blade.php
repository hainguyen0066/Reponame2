@extends('layouts.front')
@php
    $pageTitle = "Đổi mật khẩu cấp 2";
@endphp
@section('content')
<div class="columns-right">
    <div class="details-content">
        @include('partials.manage_account.breadcrumbs')
        <div class="main-details-content">
            <div class="manage-account">
                <div class="features">
                    <div class="title">{{ $pageTitle }}</div>
                    @if(empty($user->password2))
                        <h4>Bạn chưa tạo mật khẩu cấp 2 cho tài khoản, tạm thời có thể nhập mật khẩu cấp 1 để xác nhận.</h4>
                    @endif
                    <form method="POST" action="{{ route('front.password2.change.submit') }}">
                        @csrf
                        @if(!empty($user->password2))
                        <label for="old_password2">Mật khẩu cấp 2 cũ</label>
                        <input type="password" name="old_password2" id="old_password2">
                        @if ($errors->has('old_password2'))
                        <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('old_password2') }}</strong>
                            </span>
                        </div>
                        @endif
                        @else
                        <label for="old_password">Mật khẩu cấp 1</label>
                        <input type="password" name="old_password" id="old_password">
                        @if ($errors->has('old_password'))
                        <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                        </div>
                        @endif
                        @endif
                        <label for="password2">Mật khẩu cấp 2 mới</label>
                        <input type="password" name="password2" id="password2">
                        @if ($errors->has('password2'))
                            <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('password2') }}</strong>
                            </span>
                            </div>
                        @endif
                        <label for="password2_confirmation">Nhập lại mật khẩu cấp 2 mới</label>
                        <input type="password" name="password2_confirmation" id="password2_confirmation">
                        @if ($errors->has('password2_confirmation'))
                            <div class="invalid-feedback">
                            <span role="alert">
                                <strong>{{ $errors->first('password2_confirmation') }}</strong>
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
