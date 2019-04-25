<p class="h4">
    <span class="label label-dark">#{{ $item->id }}</span>
    @if($item->amount > 0)
    <span class="label label-success"><i class="voyager-dollar"></i> {{ number_format($item->amount / 1000) }}K</span>
    @endif

</p>
<p class="h4">
    <span class="label label-danger"><i class="{{ \App\Util\CommonHelper::getIconForPaymentType($item->payment_type) }}"></i>
        {{ \App\Models\Payment::displayPaymentType($item->payment_type) }}
    </span>
</p>
@if($item->payment_type == \App\Models\Payment::PAYMENT_TYPE_BANK_TRANSFER)
    <p>
        {{ $item->pay_from }}
    </p>
@endif

@if($item->payment_type == \App\Models\Payment::PAYMENT_TYPE_CARD)
    @include('partials.admin.card_info')
@endif
@if($item->note)
    <p><i class="voyager-info-circled"></i> {{ $item->note }}</p>
@endif
