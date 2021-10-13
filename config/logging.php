<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            // 'channels' => ['single', 'discord'],
            'channels' => ['daily', 'discord'],
        ],
        // logging configurations for T2G\Common
        'game_api' => [
            'driver' => 'stack',
            'channels' => ['discord', 'game_api_request'],
        ],

        'discord' => [
            'driver' => 'custom',
            'url' => env('LOG_DISCORD_WEBHOOK_URL', ''),
            'via' => \T2G\Common\Logging\DiscordMonologFactory::class,
            'level' => 'error',
        ],

        'game_api_request' => [
            'driver' => 'daily',
            'path' => storage_path('logs/game_api.log'),
            'level' => 'debug',
        ],
        'card_payment' => [
            'driver' => 'daily',
            'path' => storage_path('logs/card_payment.log'),
            'level' => 'debug',
        ],

        'card_payment_mocked' => [
            'driver' => 'single',
            'path' => storage_path('logs/card_payment_mocked.log'),
            'level' => 'debug',
        ],
        // end logging configurations for T2G\Common

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver'  => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
