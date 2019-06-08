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

    const PAYMENT_STATUS_SUCCESS                = 1;
    const PAYMENT_STATUS_PROCESSING             = 2;
    const PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR  = 3;
    const PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR = 4;
    const PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR = 5;
    const PAYMENT_STATUS_NOT_SUCCESS            = 6;
    const PAYMENT_STATUS_RECARD_NOT_ACCEPT      = 7;
    const PAY_METHOD_ZING_CARD                  = "ZingCard";
    const PAY_METHOD_RECARD                     = "Recard";
    const PAY_METHOD_BANK_TRANSFER              = "Chuyển khoản";
    const PAY_METHOD_MOMO                       = "MoMo";

    public $fillable = ['amount', 'note', 'payment_type', 'pay_from'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function statusText($isAdmin = true)
    {
        return $this->displayStatus($isAdmin);
    }

    public function info()
    {
        return view('partials.admin.payment_info', [
            'item'    => $this
        ]);
    }

    public function displayStatus($isAdmin = false)
    {
        $status = self::getPaymentStatus($this);

        return view('partials.payments.status', ['status' => $status, 'isAdmin' => $isAdmin, 'item' => $this]);
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
                    if ($payment->card_type != MobileCard::TYPE_ZING &&  empty($payment->transaction_id)) {
                        return self::PAYMENT_STATUS_RECARD_NOT_ACCEPT;
                    }
                    return self::PAYMENT_STATUS_PROCESSING; // đang xử lý
                }
            } else {
                if ($payment->card_type != MobileCard::TYPE_ZING) {

                    if($payment->gateway_status === 2) {
                        return self::PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR; // Recard trả về lỗi
                    }
                    if($payment->gateway_status === 1 && !$payment->gold_added) {
                        return self::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR; // Recard trả về OK nhưng không add được vàng cho user
                    }
                }

            }
        }

        return self::PAYMENT_STATUS_NOT_SUCCESS;
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

    /**
     * @param $value
     */
    public function setPaymentTypeAttribute($value)
    {
        $this->attributes['payment_type'] = $value;
        if (self::PAYMENT_TYPE_CARD == $value) {
            $this->attributes['pay_method'] = $this->attributes['card_type'] == MobileCard::TYPE_ZING ? self::PAY_METHOD_ZING_CARD : self::PAY_METHOD_RECARD;
        } elseif(self::PAYMENT_TYPE_MOMO == $value) {
            $this->attributes['pay_method'] = self::PAY_METHOD_MOMO;
        } elseif(self::PAYMENT_TYPE_BANK_TRANSFER == $value) {
            $this->attributes['pay_method'] = self::PAY_METHOD_BANK_TRANSFER;
        }
    }
}
