<?php

namespace App\Models;


use App\Contract\CardPaymentInterface;
use App\User;
use App\Util\MobileCard;

/**
 * Class Payment
 *
 * @property int $id
 * @property string|null $card_pin
 * @property string|null $card_serial
 * @property string|null $card_type
 * @property string|null $transaction_id
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $pay_method
 * @property string|null $pay_from
 * @property string|null $expired_date
 * @property int|null $user_id
 * @property string|null $username
 * @property int|null $server_id
 * @property int|null $payment_type
 * @property int|null $card_amount
 * @property int|null $gamecoin
 * @property int|null $gamecoin_promotion
 * @property int $status
 * @property int $finished
 * @property int $gold_added
 * @property int $gateway_status
 * @property string|null $gateway_response
 * @property string|null $gateway_amount
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $note
 * @property int|null $creator_id
 * @property int|null $amount
 * @property int|null $status_code
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGamecoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGamecoinPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGoldAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePayFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmSource($value)
 * @mixin \Eloquent
 */
class Payment extends BaseEloquentModel
{
    const PAYMENT_TYPE_CARD = 1;
    const PAYMENT_TYPE_MOMO = 3;
    const PAYMENT_TYPE_BANK_TRANSFER = 4;
    const PAYMENT_TYPE_ADVANCE_DEBT = 5;

    const PAYMENT_STATUS_SUCCESS                 = 1;
    const PAYMENT_STATUS_PROCESSING              = 2;
    const PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR   = 3;
    const PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR  = 4;
    const PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR  = 5;
    const PAYMENT_STATUS_NOT_SUCCESS             = 6;
    const PAYMENT_STATUS_CARD_GATEWAY_NOT_ACCEPT = 7;
    const PAYMENT_STATUS_ADVANCE_DEBT_SUCCESS    = 8;
    const PAY_METHOD_ZING_CARD                   = "ZingCard";
    const PAY_METHOD_RECARD                      = "Recard";
    const PAY_METHOD_NAPTHENHANH                 = "NapTheNhanh";
    const PAY_METHOD_BANK_TRANSFER               = "Chuyển khoản";
    const PAY_METHOD_MOMO                        = "MoMo";
    const PAY_METHOD_ADVANCE_DEBT                = "Tạm ứng";

    public $fillable = ['amount', 'note', 'payment_type', 'pay_from'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function getStatusText($isAdmin = true)
    {
        return self::displayStatus($this->status_code, $isAdmin);
    }

    public function info()
    {
        return view('partials.admin.payment_info', [
            'item'    => $this
        ]);
    }

    public static function displayStatus($statusCode, $isAdmin = false, $withExtraText = true)
    {
        return view('partials.payments.status', ['isAdmin' => $isAdmin, 'statusCode' => $statusCode, 'withExtraText' => $withExtraText]);
    }

    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_CARD => 'Thẻ cào',
            self::PAYMENT_TYPE_MOMO => 'MoMo',
            self::PAYMENT_TYPE_BANK_TRANSFER => 'Chuyển khoản',
            self::PAYMENT_TYPE_ADVANCE_DEBT  => self::PAY_METHOD_ADVANCE_DEBT,
        ];
    }

    public static function getPayMethods()
    {
        return [
            self::PAY_METHOD_RECARD,
            self::PAY_METHOD_NAPTHENHANH,
            self::PAY_METHOD_MOMO,
            self::PAY_METHOD_BANK_TRANSFER,
            self::PAY_METHOD_ZING_CARD,
            self::PAY_METHOD_ADVANCE_DEBT,
        ];
    }

    public static function getStatusCodes()
    {
        return [
            self::PAYMENT_STATUS_SUCCESS,
            self::PAYMENT_STATUS_PROCESSING,
            self::PAYMENT_STATUS_MANUAL_ADD_GOLD_ERROR,
            self::PAYMENT_STATUS_GATEWAY_RESPONSE_ERROR,
            self::PAYMENT_STATUS_GATEWAY_ADD_GOLD_ERROR,
            self::PAYMENT_STATUS_NOT_SUCCESS,
            self::PAYMENT_STATUS_CARD_GATEWAY_NOT_ACCEPT,
            self::PAYMENT_STATUS_ADVANCE_DEBT_SUCCESS,
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
                    if ($payment->payment_type == self::PAYMENT_TYPE_ADVANCE_DEBT) {
                        return self::PAYMENT_STATUS_ADVANCE_DEBT_SUCCESS;
                    }
                } else {
                    if ($payment->card_type != MobileCard::TYPE_ZING &&  empty($payment->transaction_id)) {
                        return self::PAYMENT_STATUS_CARD_GATEWAY_NOT_ACCEPT;
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
     * @return bool
     */
    public function isInDebt()
    {
        return self::getPaymentStatus($this) == self::PAYMENT_STATUS_ADVANCE_DEBT_SUCCESS;
    }

    /**
     * @param $value
     */
    public function setPaymentTypeAttribute($value)
    {
        $this->attributes['payment_type'] = $value;
        if (self::PAYMENT_TYPE_CARD == $value) {
            if ($this->attributes['card_type'] == MobileCard::TYPE_ZING) {
                $this->attributes['pay_method'] = self::PAY_METHOD_ZING_CARD;
            } else {
                $this->attributes['pay_method'] = env('CARD_PAYMENT_PARTNER') == CardPaymentInterface::PARTNER_NAPTHENHANH ? self::PAY_METHOD_NAPTHENHANH : self::PAY_METHOD_RECARD;
            }
        } elseif(self::PAYMENT_TYPE_MOMO == $value) {
            $this->attributes['pay_method'] = self::PAY_METHOD_MOMO;
        } elseif(self::PAYMENT_TYPE_BANK_TRANSFER == $value) {
            $this->attributes['pay_method'] = self::PAY_METHOD_BANK_TRANSFER;
        } elseif(self::PAYMENT_TYPE_ADVANCE_DEBT == $value) {
            $this->attributes['pay_method'] = self::PAY_METHOD_ADVANCE_DEBT;
        }
    }
}
