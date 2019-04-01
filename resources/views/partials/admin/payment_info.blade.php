<h4>
    <span class="label label-dark">#{{ $item->id }}</span>
    <span class="label label-danger"><i class="{{ \App\Util\CommonHelper::getIconForPaymentType($item->payment_type) }}"></i>
        {{ \App\Models\Payment::displayPaymentType($item->payment_type) }}
    </span>
    @if($item->amount > 0)
    &nbsp;<span class="label label-success"><i class="voyager-dollar"></i> {{ number_format($item->amount / 1000) }}K</span>
    @endif
</h4>
@if($item->payment_type == \App\Models\Payment::PAYMENT_TYPE_CARD)
    <p>Mã thẻ: {{ $item->card_pin }}</p>
    <p>Serial: {{ $item->card_serial }}</p>
    <p>Loại thẻ: {{ $item->card_type }}</p>
@endif
@if($item->note)
    <p><i class="voyager-info-circled"></i> {{ $item->note }}</p>
@endif
