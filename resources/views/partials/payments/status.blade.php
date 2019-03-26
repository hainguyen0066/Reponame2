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
            $text = $payment->gateway_response ? $payment->gateway_response : "Có lỗi xảy ra";
            break;
        case \App\Models\Payment::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR:
            $classes = "{$defaultClasses} label-danger c-red";
            if ($isAdmin) {
                $text = "Gateway phản hồi OK, nhưng chưa add được vàng cho user";
            } else {
                $text = "Có lỗi xảy ra" . $extended;
            }
            break;
        case \App\Models\Payment::PAYMENT_STATUS_NOT_SUCCESS:
            $classes = "{$defaultClasses} label-danger c-green";
            $text = "Không thành công";
            break;
    }
@endphp
<span class="{{ $classes }}">{{ $text }}</span>
