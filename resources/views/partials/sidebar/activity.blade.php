<div class="act-daily">
    <div class="activity-tabs">
        @php
          $slugs = [
                'Phong Lăng Độ' => ['huong-dan','phong-l-ng-do'],
                'Vượt Ải' => ['huong-dan','tinh-n-ng-v-ot-ai-thach-thuc-thoi-gian'],
                'Quả Huy Hoàng (Tiểu)' => ['huong-dan','hai-qua-huy-hoang'],
                'Chiến Trường Tống Kim' => ['huong-dan','chien-tr-ong-tong-kim'],
                'Liên Đấu' => ['huong-dan','lien-dau'],
                'Quả Huy Hoàng' => ['huong-dan','hai-qua-huy-hoang'],
                'Boss Đại Hoàng Kim' => ['su-kien','boss-dai-hoang-kim'],
                'Boss Tiểu Hoàng Kim' => ['huong-dan','boss-tieu-hoang-kim'],
                'Vận Tiêu' => ['huong-dan','trung-nguyen-tieu-cuc-tinh-n-ng-van-tieu'],
                'Trung Nguyên Loạn Chiến' => ['huong-dan','trung-nguyen-loan-chien'],
                'Quốc Chiến Thiên Tử' => ['huong-dan','quoc-chien-thien-tu'],
                'Thất Thành Đại Chiến'=> ['huong-dan','that-thanh-dai-chien'],
                'Thương Nhân Tây Vực' => ['huong-dan', 'tinh-n-ng-th-ng-nhan-tay-vuc'],
            ];
            $activities = [
                'T2' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'T3' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Vận Tiêu' => '19:00'],
                    ['Thương Nhân Tây Vực' => '19:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'T4' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Trung Nguyên Loạn Chiến' => '20:00'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'T5' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'T6' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Thương Nhân Tây Vực' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Liên Đấu' => '20:00'],
                    ['Thất Thành Đại Chiến' => '20:00'],
                    ['Chiến Trường Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'T7' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Liên Đấu' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ],
                'CN' => [
                    ['Phong Lăng Độ' => 'Đầu giờ chẵn'],
                    ['Vượt Ải' => 'Đầu mỗi giờ'],
                    ['Chiến Trường Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Chiến Trường Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Quả Huy Hoàng' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Liên Đấu' => '20:00'],
                    ['Trung Nguyên Loạn Chiến' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:30'],
                ]
            ];
            $today = date('N');
            $days = array_keys($activities);
        @endphp
        @foreach($days as $index => $day)
        <a href="javascript:" class="link-tab-daily {{ ($index + 1) == $today ? 'active' : '' }}" data-tab="tab-{{ $day }}">{{ $day }}</a>
        @endforeach
    </div>
    @foreach($days as $index => $day)
    <table class="activity-tab-container hide {{ ($index + 1) == $today ? 'active' : '' }} tab-{{ $day }}">
        @foreach($activities[$day] as $acts)
            @php
                $name = array_key_first($acts);
            @endphp
        <tr>
            <td class="td-content">
                <a href="{{ route('front.details.post', $slugs[$name])}}">{{ $name }}</a>
            </td>
            <td class="td-time">{{ $acts[$name] }}</td>
        </tr>
        @endforeach
    </table>
    @endforeach
    <div class="act-daily-view-more"><a href="{{ route('front.category', ['huong-dan']) }}">Xem thêm >></a></div>
</div>
