<?php

namespace App\Util;

use T2G\Common\Util\CommonHelper;

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

    public static function displayUpdatedDate($post,$format = 'd.m.Y')
    {
        $date = $post->updated_at ?? $post->created_at;

        return CommonHelper::formatDate($date, $format);
    }
}
