@extends('layouts.front')
@section('content')
    <div class="content-detail">
        <div class="ctdt-header">
            {{ Breadcrumbs::render('charge') }}
        </div>
        <div class="ct-nap-the">
            <h2>Thẻ cào</h2>
            <div class="title-menhgia"></div>
            <table class="card-amount-table" align="center" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Mệnh Giá Thẻ</th>
                    <th>Số Vàng</th>
                    @if($isInPromotion)
                    <th>Khuyến Mãi **</th>
                    @endif
                </tr>
                @foreach($amounts as $amount)
                <tr class="amount-row">
                    <td class="text-center">{{ number_format($amount) }} VND</td>
                    <td class="text-center text-red">{{ number_format($amount/100) }} VÀNG</td>
                    @if($isInPromotion)
                    <td class="text-center text-red">{{ number_format($amount / 100 * 0.5) }} VÀNG</td>
                    @endif
                </tr>
                @endforeach
            </table>
            @if($isInPromotion)
            <div class="text-center" style="margin-top: 15px">
                <i>**: Từ 3/1/2019 đến hết 9/1/2019 khuyến mãi 50% giá trị thẻ nạp</i>
            </div>
            @endif
            <div class="card-row">
                <div class="frm-nap">
                    <div class="title-card"></div>
                    <form action="{{ route('front.payment.submit_card') }}" method="post" id="formCharge">
                        <p>
                            <span class="frm-label"><i class='icon-next-black icon'></i>MÁY CHỦ:</span>
                            <select class="frm-input" name="server_id" id="server_id">
                                <option value="">-- Chọn Máy Chủ Đang Chơi --</option>
                                @foreach($servers as $server)
                                <option value="{{ $server->id }}">
                                    S{{ $server->game_server_id }} - {{$server->name}}
                                </option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <span class="frm-label"><i class='icon-next-black icon'></i>LOẠI THẺ:</span>
                            <select class="frm-input" name="card_type" id="card_type">
                                <option value="">-- Chọn loại thẻ cào --</option>
                                <option value="MOBIFONE" style='display:block'>-- MOBIFONE --</option>
                                <option value="VINA" style='display:block'>-- VINA PHONE --</option>
                                <option value="VIETTEL" style='display:block'>-- VIETTEL --</option>
                                {{--<option value="ZING" style='display:block'>-- ZING --</option>--}}
                            </select>
                        </p>
                        <p><span class="frm-label"><i class='icon-next-black icon'></i> SỐ SERI :</span><input
                                        class="frm-input" name="card_serial" id="card_serial" type="text"></p>
                        <p><span class="frm-label"> <i class='icon-next-black icon'></i>MÃ PIN :</span><input
                                    class="frm-input" id="card_pin" name="card_pin" type="text"></p>
                        <p>
                            <span class="frm-label"><i class='icon-next-black icon'></i>Mệnh giá:</span>
                            <select class="frm-input" name="card_amount" id="card_amount">
                                <option value="">-- Chọn mệnh giá--</option>
                                <option value="10000">10.000</option>
                                <option value="20000">20.000</option>
                                <option value="50000">50.000</option>
                                <option value="100000">100.000</option>
                                <option value="200000">200.000</option>
                                <option value="300000">300.000</option>
                                <option value="500000">500.000</option>
                            </select>
                        </p>
                        {{--<p class="capcha">--}}
                            {{--<span class="frm-label"><i class='icon-next-black icon'></i>MÃ KIỂM TRA:</span>--}}
                            {{--<img id="refesh_capcha" class="captcha_img" width="115" height="25" alt="mã kiểm tra">--}}
                        {{--</p>--}}
                        {{--<p><span class="frm-label"><i class='icon-next-black icon'></i> NHẬP MÃ KIỂM TRA:</span>--}}
                            {{--<input type="text" value="" class="required valcapt" name="valcapt" id="valcapt"--}}
                                   {{--placeholder="Nhập mã kiểm tra">--}}
                        {{--</p>--}}
                        {{--<p class="ketqua-kiemtra" style="text-align: center; width: 100%;  color: red"></p>--}}
                        <p>
                            <span class="frm-label">&nbsp;</span>
                            <button type="submit" class="btn-nap-the">Nạp thẻ</button>
                        </p>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="pp-success" id='pp-success' style='display: none'>
                    <a href="javascript:;" class='btn-close btn-close-success'></a>
                </div>
                <div class="pp-fail" id='pp-fail' style='display: none'>
                    <p class='text-err'>Vui lòng nhập đầy đủ thông tin</p>
                    <a href="javascript:;" class='btn-close'></a>
                </div>
            </div>
            {{--<div class="h-card">--}}
                {{--<div class="show-info width left">--}}
                    {{--<div class="title-giaodich width left"></div>--}}
                    {{--<table id="history-card">--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<th>STT</th>--}}
                            {{--<th>Loại thẻ</th>--}}
                            {{--<th>Seri</th>--}}
                            {{--<th>Mã Pin</th>--}}
                            {{--<th>Mệnh giá</th>--}}
                            {{--<th>Tình trạng</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>1</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>2</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>3</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>4</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>5</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>6</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>7</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>8</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>9</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>10</td>--}}
                            {{--<td>VINA</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>123456</td>--}}
                            {{--<td>100.000</td>--}}
                            {{--<td>Xử lý thành công</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {{--<div class="p-h-card">--}}
                        {{--<ul>--}}
                            {{--<li class="active">1</li>--}}
                            {{--<li class="">2</li>--}}
                            {{--<li class="">3</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection
