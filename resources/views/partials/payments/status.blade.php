@php
    $extended = $isAdmin ? "" : ". Vui lòng liên hệ BQT để được hỗ trợ.";
    $defaultClasses = $isAdmin ? "h5 label" : "label";
    switch ($status) {
        case \App\Models\Payment::PAYMENT_STATUS_SUCCESS:
            $classes = "{$defaultClasses} label-success c-green";
            $text = "Thành công";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_PROCESSING:
            $classes = "{$defaultClasses} label-primary c-green";
            $text = "Đang xử lý";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR:
            $classes = "{$defaultClasses} label-danger c-red";
            $text = "Lỗi API nạp tiền";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR:
            $classes = "{$defaultClasses} label-danger c-red";
            $text = !empty($item->gateway_response) ? $item->gateway_response : "Có lỗi xảy ra";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR:
            $classes = "{$defaultClasses} label-danger c-red";
            if ($isAdmin) {
                $extraText = "Recard phản hồi OK! nhưng lỗi API nạp tiền. <br/>Có thể duyệt lại thẻ.";
            }
            $text = "Có lỗi xảy ra" . $extended;
            break;
        case \App\Models\Payment::PAYMENT_STATUS_NOT_SUCCESS:
            $classes = "{$defaultClasses} label-danger c-red";
            $text = "Không thành công";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_RECARD_NOT_ACCEPT:
            $classes = "{$defaultClasses} label-danger c-red";
            $text = $isAdmin ? "Recard không chấp nhận thẻ" : "Thẻ không hợp lệ";
            break;
    }
@endphp
<p><span class="{{ $classes }}">{{ $text }}</span></p>
@if($isAdmin && !empty($extraText))
<p>{!! $extraText !!}</p>
@endif
