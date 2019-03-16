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
                        <li>Account: <span>{{ $user->name }}</span></li>
                        <li>Số điện thoại: {!! $user->displayPhone() !!}</li>
                        <li>Mật khẩu cấp 2: {!! $user->displayPass2() !!}</li>
                        <li>Địa chỉ ip: <span>{{request()->getClientIp()}}</span></li>
                    </ul>
                </div>
                @include('partials.manage_account.links_list')
            </div>
        </div>
    </div>
</div>
@endsection
