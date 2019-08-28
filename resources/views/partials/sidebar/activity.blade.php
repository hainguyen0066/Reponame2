<div class="act-daily">
    <div class="activity-tabs">
        <a href="javascript:;" class="link-tab-daily" data-tab="tab-daily">Hằng ngày</a>
        <a href="javascript:;" class="link-tab-activity" data-tab="tab-activity">Hoạt động</a>
    </div>
    <table class="activity-tab-container hide active tab-daily">
        <tr>
            <td class="td-time">Cả ngày</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','phong-l-ng-do'])}}">Phong Lăng Độ</a></td>
        </tr>
        <tr>
            <td class="td-time">Cả ngày</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','tinh-n-ng-v-ot-ai-thach-thuc-thoi-gian'])}}">Vượt ải</a></td>
        </tr>
        <tr>
            <td class="td-time">11:00</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','chien-tr-ong-tong-kim'])}}">Chiến trường tống kim</a></td>
        </tr>
        <tr>
            <td class="td-time">12:30</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','hai-qua-huy-hoang'])}}">Quả huy hoàng (tiểu)</a></td>
        </tr>
        <tr>
            <td class="td-time">12:30</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','boss-tieu-hoang-kim'])}}">Boss tiểu hoàng kim</a></td>
        </tr>
        <tr>
            <td class="td-time">15:00</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','chien-tr-ong-tong-kim'])}}">Chiến trường tống kim</a></td>
        </tr>
        <tr>
            <td class="td-time">19:00</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','hai-qua-huy-hoang'])}}">Quả huy hoàng</a></td>
        </tr>
        <tr>
            <td class="td-time">19:30</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['su-kien','boss-dai-hoang-kim'])}}">Boss Đại Hoàng Kim</a></td>
        </tr>
        <tr>
            <td class="td-time">20:00</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','boss-tieu-hoang-kim'])}}">Boss tiểu hoàng kim</a></td>
        </tr>
        <tr>
            <td class="td-time">21:00</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','chien-tr-ong-tong-kim'])}}">Chiến trường tống kim</a></td>
        </tr>
        <tr>
            <td class="td-time">22:30</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['su-kien','boss-dai-hoang-kim'])}}">Boss Đại Hoàng Kim</a></td>
        </tr>
    </table>
    <table class="activity-tab-container hide tab-activity">
        <tr>
            <td class="td-time">Thứ 3, 6</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','tinh-n-ng-th-ng-nhan-tay-vuc'])}}">Thương nhân Tây Vực</a></td>
        </tr>
        <tr>
            <td class="td-time">Thứ 3, 4</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','trung-nguyen-tieu-cuc-tinh-n-ng-van-tieu'])}}">Vận tiêu</a></td>
        </tr>
        <tr>
            <td class="td-time">Thứ 5</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','tinh-n-ng-loi-dai-cong-thanh'])}}">Lôi đài - Công thành</a></td>
        </tr>
        <tr>
            <td class="td-time">Thứ 6</td>
            <td class="td-content"><a href="{{ route('front.details.post', ['huong-dan','tinh-n-ng-cong-thanh-chien-tam-tru'])}}">Công thành chiến</a></td>
        </tr>
    </table>
    <div class="act-daily-view-more"><a href="{{ route('front.category', ['huong-dan']) }}">Xem thêm >></a></div>
</div>
