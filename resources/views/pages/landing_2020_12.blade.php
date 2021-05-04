<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=1920"/>
    @component('meta')
        @slot('title')
        @section('title'){{ $title ?? config('t2g_common.site.seo.title') }}@show
        @endslot
        @slot('meta_description')
            {{ $meta_description ?? config('t2g_common.site.seo.meta_description') }}
        @endslot
        @slot('meta_keywords')
            {{ $meta_keywords ?? config('t2g_common.site.seo.meta_keyword') }}
        @endslot
        @slot('meta_image')
            {{ $meta_image ?? asset(config('t2g_common.site.seo.meta_image')) }}
        @endslot
    @endcomponent
    <link rel="stylesheet" href="{{ staticUrl('css/landing-2020-12.css', true) }}">
    @include('t2g_common::schemas.home')
</head>
<body>
    <div class="loader"></div>
    @include('partials.btn_giftcode')
    <div class="wrapper">
        <section id="section-01" >
            <div class="menu-left">
                <div class="icon-top"></div>
                <div class="menu-left-content">
                    <div class="trang-chu">
                        <a href="#section-01">
                            <div id="menu01" class="trang-chu-number"><span>01</span></div>
                            <div class="number-content">trang chủ</div>
                            <div class="separator"></div>
                        </a>
                    </div>
                    <div class="su-kien">
                        <a href="#section-02">
                            <div id="menu02" class="trang-chu-number"><span>02</span></div>
                            <div class="number-content">sự kiện</div>
                            <div class="separator"></div>
                        </a>
                    </div>
                    <div class="dac-diem">
                        <a href="#section-03">
                            <div id="menu03" class="trang-chu-number"><span>03</span></div>
                            <div class="number-content">đặc sắc</div>
                            <div class="separator"></div>
                        </a>
                    </div>
                    <div class="dinh-huong">
                        <a href="#section-05">
                            <div id="menu04" class="trang-chu-number"><span>04</span></div>
                            <div class="number-content">định hướng</div>
                            <div class="separator"></div>
                        </a>
                    </div>
                    <div class="ho-tro">
                        <a href="#section-06">
                            <div id="menu05" class="trang-chu-number"><span>05</span></div>
                            <div class="number-content">hỗ trợ</div>
                        </a>
                    </div>
                </div>
                <div class="icon-bottom"></div>
            </div>
            <div class="logo"><a href="{{ route('front.home')}}"></a></div>
            <div data-aos="fade-right"  class="menu">
                <ul>
                    <li><a href="{{ route('front.home')}}">Trang chủ</a></li>
                    <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                    <li><a href="{{ config('site.fb.group_url')}}" target="_blank">Group</a></li>
                </ul>
            </div>
            <video id="intro" class="video-bg" preload="auto" loop muted autoplay playsinline
                poster="{{ staticUrl('images/landing-2020-12/section-01-bg.jpg') }}">
                <source src="{{ staticUrl('images/landing-2020-12/bg_frame1.mp4') }}" type="video/mp4">
            </video>
            <a  class="register-btn {{ $user ? 'logged' : 'account-register' }}" title="Đăng ký"></a>
            <div data-aos="fade-right" data-aos-delay="1000"  class="text"></div>
            <div data-aos="fade-right" data-aos-delay="1500" class="logo-congthanhchien"></div>
            <div data-aos="fade-right" data-aos-delay="2000" class="text-server-moi"></div>
            <div data-aos="fade-left" data-aos-delay="2000" class="down-and-giftcode">
                <a class="download" target="_blank" href="{{ route('front.page.download')}}" title="Tải game">
                    <video class="video-bg" data-url="{{ staticUrl('images/landing-2020-12/nut_tai_game_thanh_do.webm') }}"
                           preload="auto" loop muted autoplay playsinline>
                        <source src="{{ staticUrl('images/landing-2020-12/nut_tai_game_thanh_do.webm') }}" type="video/webm">
                    </video>
                </a>

                <a class="register account-register {{ $user ? 'logged' : '' }}" href="javascript:" title="Nhận Code">
                    <video class="video-bg" preload="auto" loop muted autoplay playsinline>
                        <source src="{{ staticUrl('images/landing-2020-12/nut_dang_ky.webm') }}" type="video/webm">
                    </video>
                </a>
            </div>
            <video class="video-bg characters-f1" preload="auto" loop muted autoplay playsinline>
                <source src="{{ staticUrl('images/landing-2020-12/nhan_vat_frame1.webm') }}" type="video/webm">
            </video>
            <div data-aos="zoom-in-left" class="update-special"></div>
        </section>
        <section id="section-02">
            <div class="event-special container">
                <div class="event-title"></div>
                <div class="event-content">
                    <a data-aos="zoom-out-down" data-aos-delay="" href="{{ route('front.details.post', ['su-kien','vo-lam-tranh-ba'])}}" title="Võ Lâm Tranh Bá"></a>
                    <a data-aos="zoom-out-down" href="{{ route('front.details.post', ['su-kien','su-kien-xung-ba-tong-kim']) }}" data-aos-delay="300" title="Tống Kim Xưng Bá"></a>
                    <a data-aos="zoom-out-down" href="{{ route('front.details.post', ['su-kien','tuyet-dinh-su-quan']) }}" data-aos-delay="600" title="Tuyệt Đỉnh Sứ Quân"></a>
                    <a data-aos="zoom-out-down" href="{{ route('front.details.post', ['tong-hop','su-kien-anh-hung-thiep']) }}" data-aos-delay="900" title="Anh Hùng Thiếp"></a>
                </div>
            </div>
        </section>
        <section id="section-03">
            <div class="update-special container">
                <div class="update-title"></div>
                <div class="update-content">
                    <a data-aos="fade-right"
                       data-aos-easing="ease-in-sine" href="#" title="Hệ Thống Chống Kéo Xe Liên Máy"></a>
                    <a data-aos="fade-right"
                       data-aos-easing="ease-in-sine"  data-aos-delay="300" href="#" title="Thập Đại Môn Phái Cân Bằng"></a>
                    <a data-aos="fade-right"
                       data-aos-easing="ease-in-sine"  data-aos-delay="600" href="#" title="Cân Bằng Tiền Vạn Hoàn Hảo"></a>
                </div>
            </div>
        </section>
        <section id="section-04">
            <div class="info-server container">
                <div class="info-title"></div>
                <div class="info-content">
                    <ul data-aos="zoom-in-left">
                        <li><span class="icon" ></span><p>Đã hoạt động <span>2 năm</span> cực kỳ ổn định</p></li>
                        <li><span class="icon" ></span><p>Chống <span>Máy Ảo</span> Tuyệt Đối</p></li>
                        <li><span class="icon" ></span><p>Chống <span>Multi Login</span> Tuyệt Đối</p></li>
                        <li><span class="icon" ></span><p>Tính năng <span>cân bằng cấp độ</span></p></li>
                        <li><span class="icon" ></span><p>Drop chuẩn VNG <span>đồ xanh cực hiếm</span></p></li>
                        <li><span class="icon" ></span><p>PB <span>Đường Môn Thân Pháp</span> rất được yêu thích</p></li>
                        <li><span class="icon" ></span><p>Trang bị chuẩn <span>Đồ Xanh, An Bang, Định
                                Quốc, HKMP</span> cực hiếm</p></li>
                    </ul>
                    <ul data-aos="zoom-in-right">
                        <li><span class="icon" ></span><p>Đã tổ chức thành công nhiều <span>giải đấu</span> lớn</p></li>
                        <li><span class="icon" ></span><p>Chặn hoàn toàn <span>Script</span></p></li>
                        <li><span class="icon" ></span><p>Hệ thống tính năng <span>chuẩn VNG</span></p></li>
                        <li><span class="icon" ></span><p>Giới hạn <span>4 account/PC - 8 account/IP</span></p></li>
                        <li><span class="icon" ></span><p>Tính năng <span>Vận Tiêu - Loạn Chiến</span> độc quyền.</p></li>
                        <li><span class="icon" ></span><p><span>Miễn Phí</span> Giờ Chơi</p></li>
                    </ul>
                </div>
            </div>
        </section>
        <div class="join-now">
            <div class="join-text">phù hợp với người có ít thời gian</div>
            <a data-aos="zoom-out-down" class="join-btn" href="{{ route('front.page.download') }}" title="Tham Gia Ngay"></a>
            <div data-aos="fade-down-left" class="character"></div>
        </div>
        <section id="section-05">
                <div data-aos="zoom-in" class="dinhhuong-phattrien"></div>
        </section>
        <section id="section-06">
            <div class="container">
                <div class="hotro-tanthu-title"></div>
                <div class="hotro-tanthu-content">
                    <div data-aos="zoom-out-left" class="gift-left">
                        <span class="gift-lv10">thưởng lv10</span>
                        <ul>
                            <li><span class="icon"></span><p>Full kỹ năng tới LV60</p></li>
                            <li><span class="icon"></span><p>Buff tân thủ đến hết LV59</p></li>
                            <li><span class="icon"></span><p>Máu tân thủ đến hết LV59</p></li>
                            <li><span class="icon"></span><p>Thần Hành Phù (3 ngày)</p></li>
                            <li><span class="icon"></span><p>Thổ Địa Phù (100 lần)</p></li>
                            <li><span class="icon"></span><p>1 Bình Tiên Thảo Lộ vĩnh viễn Sử dụng đến hết Level 79</p></li>
                        </ul>
                    </div>
                    <div  data-aos="zoom-out-right" class="gift-right">
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv20</div>
                            <div class="gift-lv-content">
                                <span class="icon"></span><p>giày kim phong</p>
                            </div>
                        </div>
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv30</div>
                            <div class="gift-lv-content">
                                <div class="d-flex"><span class="icon"></span><p>áo kim phong</p></div>
                                <div class="d-flex"><span class="icon"></span><p>dây chuyền k.phong</p></div>
                            </div>
                        </div>
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv40</div>
                            <div class="gift-lv-content">
                                <span class="icon"></span><p>nón, ngọc bội, nhẫn kim phong</p>
                            </div>
                        </div>
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv50</div>
                            <div class="gift-lv-content">
                                <div class="d-flex"><span class="icon"></span><p>đai kim phong</p><</div>
                                <div class="d-flex"><span class="icon"></span><p>hộ uyển kim phong</p></div>
                            </div>
                        </div>
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv60</div>
                            <div class="gift-lv-content">
                                <div class="d-flex"><span class="icon"></span><p>nhẫn kim phong</p><</div>
                                <div class="d-flex"><span class="icon"></span><p>ngựa túc sương</p></div>
                            </div>
                        </div>
                        <div class="gift-lv">
                            <div class="gift-lv-title">thưởng lv80</div>
                            <div class="gift-lv-content">
                                <span class="icon"></span><p>mã bài ngẫu nhiên 7 ngày</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="volam-2005">
                    <a href="{{ route('front.page.download') }}" data-aos="zoom-out-down" class="btn-volam2005" target="_blank" title="Tôi Muốn Thử"></a>
                </div>
            </div>
        </section>
        <section id="section-07">
            <div data-aos="fade-down-right" class="character"></div>
            <div class="info-support">
                <p class="text"><span>hỗ trợ chăm sóc </span><span class="text-yellow">nhiệt tình thân thiện</span></p>
                <p class="phone"><span>0898 022 151</span><span>0762 953 004</span></p>
                <p class="question">vẫn còn thắc mắc đặt câu hỏi <a data-aos="zoom-out-down" class="btn-support" href="{{ config('site.fb.page_url') }}" target="_blank"></a></p>
            </div>
        </section>
        <footer>
            <!-- <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span>{{ parse_url(url()->current())['host'] }}</span></p> -->
            <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span>Võ Lâm Trung Nguyên Team</span></p>
            <p>Địa chỉ: 21 Nguyễn Thái Học, phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</p>
            <p>Điện thoại: <span>0898 002 151</span> Fanpage : <a href="{{ config('site.fb.page_url') }}" target="blank" title="Fanpage">{{ config('site.fb.page_url') }}</a></p>
        </footer>
    </div>

@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
    @include('modal.giftcode')
@section('js')
    <script>
        window.user_id = '{{ $user ? $user->id : '' }}';
    </script>
    <script type="text/javascript" src="{{ staticUrl('js/landing-2020-12.js', true) }}"></script>
@show
@include('partials.tracker.fb_chat')
</body>
</html>
