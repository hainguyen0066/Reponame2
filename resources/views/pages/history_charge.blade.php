@extends('layouts.front')
@php
$cardTypes = \App\Util\MobileCard::getCardList();
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
                            <th>STT</th>
                            <th>Loại thẻ</th>
                            <th>Seri</th>
                            <th>Mã thẻ</th>
                            <th>Mệnh giá</th>
                            <th>Tình trạng</th>
                        </tr>
                        @foreach($histories as $history)
                        <tr>
                            <td>1</td>
                            <td>{{ $cardTypes[$history->card_type] }}</td>
                            <td>{{ $history->card_serial }}</td>
                            <td>{{ $history->card_pin }}</td>
                            <td>{{ number_format($history->card_amount) }}</td>
                            <td>{!! $history->statusText() !!}</td>
                        </tr>
                        @endforeach
                        @if($histories->total() == 0)
                            <tr>
                                <td colspan="6">Không có lịch sử giao dịch</td>
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
