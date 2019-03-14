@extends('layouts.front')
@section('content')
<div class="columns-right">
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">Trung tâm thông báo</p>
            <ul>
                <li><a href="{{ route('front.home')}}">Trang Chủ</a></li>
                <li><a href="{{  route('front.manage.account.info') }}" class="c-white">Quản lý tài khoản</a></li>
                <li><a href="" class="c-white">Đổi mật khẩu cấp 2</a></li>
            </ul>
        </div>
        <div class="main-details-content">                                
            <div class="manage-account">
                <div class="features">
                    <div class="title">Đổi mật khẩu cấp 2</div>
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
                <div class="list-features">
                    <div class="title">Danh mục quản lý</div>
                    <ul>
                        <li class=""><a href="{{  route('front.manage.account.info') }}">Thông tin tài khoản</a></li>
                        <li class=""><a href="{{  route('front.manage.account.history') }}">Lịch sử giao dịch</a></li>
                        <li class=""><a href="{{  route('front.manage.account.pass') }}">Đổi mật khẩu cấp 1</a></li>
                        <li class="active"><a href="{{  route('front.manage.account.pass2') }}">Đổi mật khẩu cấp 2</a></li>
                        <li class=""><a href="{{ route('front.static.chuyen_khoan') }}" style="line-height: 30px;">Nạp thẻ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
