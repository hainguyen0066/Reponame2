<div class="act-daily">
    <div class="activity-tabs">
        @php
          $slugs = [
                'Phong Lăng Độ' => ['huong-dan','phong-l-ng-do'],
                'Vượt Ải' => ['huong-dan','tinh-n-ng-v-ot-ai-thach-thuc-thoi-gian'],
                'Quả Huy Hoàng (Tiểu)' => ['huong-dan','hai-qua-huy-hoang'],
                'Tống Kim' => ['huong-dan','chien-tr-ong-tong-kim'],
                'Liên Đấu' => ['huong-dan','lien-dau'],
                'Quả Huy Hoàng' => ['huong-dan','hai-qua-huy-hoang'],
                'Boss Đại Hoàng Kim' => ['su-kien','boss-dai-hoang-kim'],
                'Boss Tiểu Hoàng Kim' => ['huong-dan','boss-tieu-hoang-kim'],
                'Vận Tiêu' => ['huong-dan','tieu-cuc-tinh-n-ng-van-tieu'],
                'Loạn Chiến Cổ Mộ' => ['huong-dan','loan-chien-co-mo'],
                'Quốc Chiến Thiên Tử' => ['huong-dan','quoc-chien-thien-tu'],
                'Thất Thành Đại Chiến'=> ['huong-dan','that-thanh-dai-chien'],
                'Thương Nhân Tây Vực' => ['huong-dan', 'tinh-n-ng-th-ng-nhan-tay-vuc'],
            ];
            $activities = [
                'T2' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quả Huy Hoàng' => '20:00'],
                    ['Quốc Chiến Thiên Tử' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'T3' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Thương Nhân Tây Vực' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Vận Tiêu' => '20:00'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'T4' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Loạn Chiến Cổ Mộ' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'T5' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Vận Tiêu' => '20:00'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quả Huy Hoàng' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'T6' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Thương Nhân Tây Vực' => '19:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Liên Đấu' => '20:00'],
                    ['Thất Thành Đại Chiến' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'T7' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Boss Tiểu Hoàng Kim' => '20:00'],
                    ['Quả Huy Hoàng' => '20:00'],
                    ['Liên Đấu' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
                ],
                'CN' => [
                    ['Phong Lăng Độ' => 'Giờ Chẵn'],
                    ['Vượt Ải' => 'Cả Ngày'],
                    ['Tống Kim' => '11:00'],
                    ['Boss Tiểu Hoàng Kim' => '12:30'],
                    ['Quả Huy Hoàng (Tiểu)' => '12:30'],
                    ['Tống Kim' => '15:00'],
                    ['Liên Đấu' => '18:00'],
                    ['Boss Đại Hoàng Kim' => '19:30'],
                    ['Liên Đấu' => '20:00'],
                    ['Loạn Chiến Cổ Mộ' => '20:00'],
                    ['Tống Kim' => '21:00'],
                    ['Boss Đại Hoàng Kim' => '22:45'],
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
        <tr class="border-custom">
            <td class="td-content">
                <a href="{{ route('front.details.post', $slugs[$name])}}">{{ $name }}</a>
            </td>
            <td class="td-time"><span>{{ $acts[$name] }}</span></td>
        </tr>
        @endforeach
    </table>
    @endforeach
</div>
