@extends('layouts.front')
@php
    $pageTitle = "Thông tin tài khoản";
@endphp
@section('content')
<div class="columns-right">
    <div class="details-content">
        @include('partials.manage_account.breadcrumbs')
        <div class="main-details-content">
            <div class="manage-account">
                <div class="features">
                    <div class="title">{{ $pageTitle }}</div>
                    <ul>
                        <li><p>Account:</p> <span>{{ $user->name }}</span></li>
                        <li><p>Số điện thoại:</p> {!! $user->displayPhone() !!}</li>
                        <li><p>Mật khẩu cấp 2:</p> {!! $user->displayPass2() !!}</li>
                        <li><p>Địa chỉ ip:</p> <span>{{request()->getClientIp()}}</span></li>
                    </ul>
                </div>
                @include('partials.manage_account.links_list')
            </div>
        </div>
    </div>
</div>
@endsection
