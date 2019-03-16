@extends('layouts.front')
@php
    $pageTitle = "Đổi mật khẩu cấp 2";
@endphp
@section('content')
<div class="columns-right">
    <div class="details-content">
        v
        <div class="main-details-content">                                
            <div class="manage-account">
                <div class="features">
                    <div class="title">{{ $pageTitle }}</div>
                    <form action="">
                        <label for="old-password">Mật khẩu cấp 2 cũ</label>
                        <input type="password" name="old-password" id="old-password">
                        <label for="password">Mật khẩu cấp 2 mới</label>
                        <input type="password" name="password" id="password">
                        <label for="re-password">Mật khẩu cấp 2 mới</label>
                        <input type="password" name="re-password" id="re-password">
                        <div class="c-red"></div>
                        <button type="submit" value="">Cập nhật</button>
                    </form>
                </div>
                @include('partials.manage_account.links_list')
            </div>
        </div>
    </div>
</div>
@endsection
