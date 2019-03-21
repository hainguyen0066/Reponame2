<?php

namespace App\Util;

/**
 * Class GameApiLog
 *
 * @package \App\Util
 */
class GameApiLog
{
    public static function getChanne()
    {

    }
    
    public static function notify($message, $data = [])
    {
        $channel = env('GAME_API_MOCK') ? 'game_api_request' : 'game_api';
        $message = "[" . time() . "] " . $message;
        \Log::channel($channel)->critical($message, $data);
    }
}
