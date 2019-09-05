<p class="h4"><span class="label label-dark">#{{ $data->id }}</span></p>
@if($data->payment_type == \App\Models\Payment::PAYMENT_TYPE_CARD)
    <p class="hidden-xs">{{ $data->pay_method }}</p>
@endif
