<?php

namespace App\Util;

use App\Models\Payment;

/**
 * Class CommonHelper
 *
 * @package \App\Util
 */
class CommonHelper
{
    /**
     * @return array
     */
    public static function getCategories()
    {
        return [
            'tong-hop'  => 'Tổng hợp',
            'thong-bao' => 'Thông báo',
            'su-kien'   => 'Sự kiện',
            'huong-dan' => 'Hướng dẫn',
        ];
    }

    /**
     * @return array
     */
    public static function getNewsCategories()
    {
        return [
            'tong-hop'  => 'Tổng hợp',
            'thong-bao' => 'Thông báo',
            'su-kien'   => 'Sự kiện',
        ];
    }

    public static function formatDate($date, $format = 'd-m')
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }

        return $date->format($format);
    }

    /**
     * @param string $href
     * @param string $quote
     * @param string $hashTag
     * @param string $redirectUri
     * @param string $display
     *
     * @return string
     */
    public static function getFbShareUrl($href = '', $quote = '', $hashTag = '', $redirectUri = '', $display = 'popup')
    {
        $href = $href ? $href : url()->current();
        $params = [
            'app_id'       => config('site.fb.app_id'),
            'display'      => $display,
            'href'         => $href,
            'redirect_uri' => $redirectUri,
            'quote'        => $quote,
            'hashtag'      => $hashTag,
        ];

        return "https://www.facebook.com/dialog/share?" . http_build_query($params);
    }

    public static function getIconForPaymentType($paymentType)
    {
        $icons = [
            Payment::PAYMENT_TYPE_CARD => 'voyager-credit-card',
            Payment::PAYMENT_TYPE_MOMO => 'voyager-wallet',
            Payment::PAYMENT_TYPE_BANK_TRANSFER => 'voyager-receipt',
        ];

        return $icons[$paymentType] ?? 'voyager-exclamation';
    }
}
