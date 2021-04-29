@extends('layouts.front')
@php
$cardTypes = \T2G\Common\Util\MobileCard::getCardList();
$pageTitle = "Lịch sử giao dịch";
@endphp
@section('content')
<div class="columns-right">
    <div class="details-content">
        @include('partials.manage_account.breadcrumbs')
        <div class="main-details-content">
            <div class="manage-account">
                <div class="features">
                    <div class="title">Lịch sử giao dịch</div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin</th>
                            <th>Số tiền</th>
                            <th>Số Xu</th>
                            <th>Tình trạng</th>
                        </tr>
                        @foreach($histories as $history)
                            <tr>
                                <td align="center">{{ $history->id }}</td>
                                <td>
                                    <h4>
                                        {{ \T2G\Common\Models\Payment::displayPaymentType($history->payment_type, false) }}
                                    </h4>
                                    @if($history->payment_type == \T2G\Common\Models\Payment::PAYMENT_TYPE_CARD)
                                        <p>Mã thẻ: {{ $history->card_pin }}</p>
                                        <p>Serial: {{ $history->card_serial }}</p>
                                        <p>Loại thẻ: {{ $history->card_type }}</p>
                                    @endif
                                </td>
                                <td align="right">{{ number_format($history->amount) }} VNĐ</td>
                                <td align="right">{{ number_format($history->gamecoin) }}</td>
                                <td align="center">{!! $history->getStatusText(false) !!}</td>
                            </tr>
                        @endforeach
                        @if($histories->total() == 0)
                            <tr>
                                <td colspan="5">Không có lịch sử giao dịch</td>
                            </tr>
                        @endif
                    </table>
                </div>
                @if($histories->total() > 0)
                <div class="center">
                    {{ $histories->links() }}
                </div>
                @endif
                @include('partials.manage_account.links_list')
            </div>
        </div>
    </div>
</div>
@endsection
