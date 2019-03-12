@extends('layouts.front')
@section('content')
<div class="columns-right">
    <div class="details-content">
        <div class="header-details-content">
            <p class="c-white">Trung tâm thông báo</p>
            <ul>
                <li><a href="#">Trang Chủ</a></li>
                <li><a href="#" class="c-white">Quản lý tài khoản</a></li>
                <li><a href="" class="c-white">Đổi mật khẩu cấp 1</a></li>
            </ul>
        </div>
        <div class="main-details-content">                                
            <div class="manage-account">
                <div class="features">
                    <div class="title">Đổi mật khẩu cấp 1</div>
                    <form action="">
                        <label for="old-password">Mật khẩu cấp 1 cũ</label>
                        <input type="password" name="old-password" id="old-password">
                        <label for="password">Mật khẩu cấp 1 mới</label>
                        <input type="password" name="password" id="password">
                        <label for="re-password">Mật khẩu cấp 1 mới</label>
                        <input type="password" name="re-password" id="re-password">
                        <div class="c-red"></div>
                        <button type="submit" value="">Cập nhật</button>
                    </form>
                </div>
                <div class="list-features">
                    <div class="title">Danh mục quản lý</div>
                    <ul>
                        <li class=""><a href="{{ route('front.password.change.pass') }}">Thông tin tài khoản</a></li>
                        <li class=""><a href="{{ route('front.password.change.pass') }}">Cập nhật thông tin</a></li>
                        <li class=""><a href="{{ route('front.password.change.pass') }}">Lịch sử giao dịch</a></li>
                        <li class="active"><a href="{{ route('front.password.change.pass') }}">Đổi mật khẩu cấp 1</a></li>
                        <li class=""><a href="{{ route('front.password.change.pass2') }}">Đổi mật khẩu cấp 2</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
