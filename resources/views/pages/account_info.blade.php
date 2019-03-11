@extends('layouts.front')
@section('content')
<div class="columns-right">
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">Trung tâm thông báo</p>
            <ul>
                <li><a href="#">Trang Chủ</a></li>
                <li><a href="#" class="c-white">Quản lý tài khoản</a></li>
                <li><a href="" class="c-white">Thông tin tài khoản</a></li>
            </ul>
        </div>
        <div class="main-details-content">                                
            <div class="manage-account">
                <div class="features">
                    <div class="title">Thông tin tài khoản</div>
                    <ul>
                        <li>Account: <span class="c-red">tuanle001</span></li>
                        <li>Số điện thoại: <span class="c-red">chưa cập nhật</span></li>
                        <li>Mật khẩu cấp 2: <span class="c-red">chưa cập nhật</span></li>
                        <li>Địa chỉ ip: <span class="c-red">192.168.1.111</span></li>
                    </ul>
                </div>
                <div class="list-features">
                    <div class="title">Danh mục quản lý</div>
                    <ul>
                        <li class="active"><a href="{{  route('front.manage.account.info') }}">Thông tin tài khoản</a></li>
                        <li class=""><a href="{{  route('front.manage.account.history') }}">Lịch sử giao dịch</a></li>
                        <li class=""><a href="{{  route('front.manage.account.pass') }}">Đổi mật khẩu cấp 1</a></li>
                        <li class=""><a href="{{  route('front.manage.account.pass2') }}">Đổi mật khẩu cấp 2</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
