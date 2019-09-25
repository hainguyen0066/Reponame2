<?php

namespace App\Util;

/**
 * Class Helper
 *
 * @package \App\Util
 */
class Helper
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
}
