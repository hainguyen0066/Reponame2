<div class="manage-charge">
    <div class="charge">
        <div class="title">Nạp thẻ</div>
        <form action="">
            <div class="item">
                <div class="label"><label for="card_type">Loại thẻ:</label></div>
                <div class="content">
                    <select name="card_type" id="card_type">
                        <option value="">-- Chọn loại thẻ cào --</option>
                        @foreach(\App\Util\MobileCard::getCardList() as $val => $name)
                        <option value="{{ $val }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="item">
                <div class="label"><label for="card_serial">Số seri:</label></div>
                <div class="content">
                    <input type="text" name="card_serial" id="card_serial">
                </div>
            </div>
            <div class="item">
                <div class="label"><label for="card_pin">Mã pin:</label></div>
                <div class="content">
                    <input type="text" name="card_pin" id="card_pin">
                </div>
            </div>
            <div class="item">
                <div class="label"><label for="menh-gia">Loại thẻ:</label></div>
                <div class="content">
                    <select name="menh-gia" id="menh-gia">
                    <option value="">-- Chọn mệnh giá --</option>
                        @foreach(\App\Util\MobileCard::getAmountList() as $val)
                            <option value="{{ $val }}">{{ number_format($val) }} VNĐ</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{--<div class="item">--}}
                {{--<div class="label"><label>Mã kiểm tra</label></div>--}}
                {{--<div class="content">--}}
                    {{--aaaaaaaaaaaaaa--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="item">
                <div class="label"><label for="ma-kiem-tra">Mã pin:</label></div>
                <div class="content">
                    <input type="text" name="ma-kiem-tra" id="ma-kiem-tra">
                </div>
            </div>
            <div class="item">
                <div class="content payment-message"></div>
            </div>
            <div class="item">
                <div class="label"><label for=""></label></div>
                <div class="content">
                    <button id="btnUseCard" type="submit">Nạp thẻ</button>
                    <a href="{{ route('front.payment.history') }}">Lịch sử giao dịch</a>
                </div>
            </div>
        </form>
    </div>
</div>
