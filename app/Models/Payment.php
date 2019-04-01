<?php

namespace App\Models;


use App\User;
use App\Util\MobileCard;

/**
 * Class Payment
 *
 * @package \App\Models
 */
class Payment extends BaseEloquentModel
{
    const PAYMENT_TYPE_CARD = 1;
    const PAYMENT_TYPE_MOMO = 3;
    const PAYMENT_TYPE_BANK_TRANSFER = 4;

    const PAYMENT_STATUS_SUCCESS = 1;
    const PAYMENT_STATUS_PROCESSING = 2;
    const PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR = 3;
    const PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR = 4;
    const PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR = 5;
    const PAYMENT_STATUS_NOT_SUCCESS = 6;

    public $fillable = ['amount', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function statusText()
    {
        return $this->displayStatus(true);
    }

    public function info()
    {
        return view('partials.admin.paymentInfo', [
            'item'    => $this
        ]);
    }

    public function displayStatus($isAdmin = false)
    {
        $status = self::getPaymentStatus($this);

        return view('partials.payments.status', ['status' => $status, 'isAdmin' => $isAdmin]);
    }

    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_CARD => 'Thẻ cào',
            self::PAYMENT_TYPE_MOMO => 'MoMo',
            self::PAYMENT_TYPE_BANK_TRANSFER => 'Chuyển khoản'
        ];
    }

    /**
     * @param \App\Models\Payment $payment
     *
     * @return int
     */
    public static function getPaymentStatus(Payment $payment)
    {
        if ($payment->status && $payment->finished) {
            return self::PAYMENT_STATUS_SUCCESS; // thành công
        } else {
            if (!$payment->finished) {
                if ($payment->payment_type != Payment::PAYMENT_TYPE_CARD) {
                    if (!$payment->gold_added) {
                        // lỗi API nạp tiền
                        return self::PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR;
                    }
                } else {
                    return self::PAYMENT_STATUS_PROCESSING; // đang xử lý
                }
            } else {
                if ($payment->card_type != MobileCard::TYPE_ZING) {
                    if($payment->gateway_status == 2) {
                        return self::PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR; // Recard trả về lỗi
                    }
                    if($payment->gateway_status == 1 && $payment->gold_added) {
                        return self::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR; // Recard trả về OK nhưng không add được vàng cho user
                    }
                }
                return self::PAYMENT_STATUS_NOT_SUCCESS; // không thành công - unknown error
            }
        }
    }

    /**
     * @param $paymentType
     *
     * @return mixed|string
     */
    public static function displayPaymentType($paymentType)
    {
        $types = self::getPaymentTypes();

        return $types[$paymentType] ?? "Unknown";
    }

    /**
     * @param \App\Models\Payment $payment
     *
     * @return bool
     */
    public static function isAcceptable(Payment $payment)
    {
        $status = self::getPaymentStatus($payment);

        return $payment->payment_type
            && (
                $status == self::PAYMENT_STATUS_PROCESSING
                || $status == self::PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR
                || $status == self::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR
            );
    }

    /**
     * @param \App\Models\Payment $payment
     *
     * @return bool
     */
    public static function isRejectable(Payment $payment)
    {
        return self::isAcceptable($payment);
    }

    public function isDone()
    {
        return self::getPaymentStatus($this) == self::PAYMENT_STATUS_SUCCESS;
    }
}
