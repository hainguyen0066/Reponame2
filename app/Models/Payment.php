<?php

namespace App\Models;


use App\Util\MobileCard;

/**
 * Class Payment
 *
 * @package \App\Models
 */
class Payment extends BaseEloquentModel
{
    const PAYMENT_TYPE_MOBILECARD = 1;
    const PAYMENT_TYPE_ZINGCARD = 2;
    const PAYMENT_TYPE_MOMO = 3;
    const PAYMENT_TYPE_BANK_TRANSFER = 4;

    public function statusText()
    {
        return $this->displayStatus(true);
    }

    public function cardInfo()
    {
        return view('partials.admin.cardInfo', [
            'pin'    => $this->card_pin,
            'serial' => $this->card_serial,
            'type'   => $this->card_type,
        ]);
    }

    public function displayStatus($isAdmin = false)
    {
        $extended = $isAdmin ? "" : ". Vui lòng liên hệ BQT để được hỗ trợ.";
        if ($this->status) {
            $msg = "<span class='c-green'>Thành công!</span>";
        } else {
            if (!$this->finished) {
                $msg = "<span  class='label label-info'>Đang xử lý</span>";
            } else {
                $msg = "<span  class='label label-danger c-red'>Không thành công</span>";
                if ($this->card_type != MobileCard::TYPE_ZING) {
                    if($this->gateway_status == 2) {
                        $text = $this->gateway_response ? $this->gateway_response : "Có lỗi xảy ra";
                        $msg = "<span class='label label-danger c-red'>{$text}{$extended}</span>";
                    }
                    if($this->gateway_status == 1 && $this->gold_added) {
                        if ($isAdmin) {
                            $text = "Gateway phản hồi OK, nhưng chưa add được vàng cho user";
                        } else {
                            $text = "Có lỗi xảy ra" . $extended;
                        }
                        $msg = "<span class='label label-warning c-orange'>{$text}</span>";
                    }
                }
            }
        }

        return $msg;
    }
}
