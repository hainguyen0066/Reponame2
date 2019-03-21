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
        $extended = $isAdmin ? "" : ". Vui lòng liên hệ BQT để được hỗ trợ.";
        $extendedClass = $isAdmin ? "h5" : "";
        if ($this->status) {
            $msg = "<span class='{$extendedClass} label label-success c-green'>Thành công!</span>";
        } else {
            if (!$this->finished) {
                if ($this->payment_type != Payment::PAYMENT_TYPE_CARD) {
                    if (!$this->gold_added) {
                        $msg = "<span  class='{$extendedClass} label label-primary'>Lỗi API nạp tiền</span>";
                    }
                } else {
                    $msg = "<span  class='{$extendedClass} label label-primary'>Đang xử lý</span>";
                }
            } else {
                $msg = "<span  class='{$extendedClass} label label-danger c-red'>Không thành công</span>";
                if ($this->card_type != MobileCard::TYPE_ZING) {
                    if($this->gateway_status == 2) {
                        $text = $this->gateway_response ? $this->gateway_response : "Có lỗi xảy ra";
                        $msg = "<span class='{$extendedClass} label label-danger c-red'>{$text}{$extended}</span>";
                    }
                    if($this->gateway_status == 1 && $this->gold_added) {
                        if ($isAdmin) {
                            $text = "Gateway phản hồi OK, nhưng chưa add được vàng cho user";
                        } else {
                            $text = "Có lỗi xảy ra" . $extended;
                        }
                        $msg = "<span class='{$extendedClass} label label-warning c-orange'>{$text}</span>";
                    }
                }
            }
        }

        return $msg;
    }

    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_CARD => 'Thẻ cào',
            self::PAYMENT_TYPE_MOMO => 'MoMo',
            self::PAYMENT_TYPE_BANK_TRANSFER => 'Chuyển khoản'
        ];
    }

    public function displayPaymentType()
    {
        $types = self::getPaymentTypes();
        return isset($types[$this->payment_type]) ? $types[$this->payment_type] : "Unknown";
    }
}
