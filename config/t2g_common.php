<?php

return [
    'asset' => [
        'version' => '202104203201',
        'base_url' => env('ASSET_BASE_URL'),
    ],
    'site'     => [
        'domains' => ['vltrungnguyen.com', 'www.vltrungnguyen.com', 'vltrungnguyen.net', 'www.vltrunglnguyen.net'],
        'seo'     => [
            'title'            => 'Võ Lâm Trung Nguyên',
            'meta_keyword'     => 'vo lam trung nguyen, vltk hay, game pk hay, volam1, ctc, vo lam ctc, vo lam cong thanh chien, vo lam 1',
            'meta_description' => 'Khai mở Server Phật Sơn - 19h00 ngày 08/05/2021. Với sự góp mặt của các đại bang đến từ khắp chốn giang hồ. Sự trở lại của 1 huyền thoại với 1 diện mạo hoàn toàn mới - Nơi 1 Huyền Thoại mới của giới private xuất hiện',
            'meta_image'       => 'images/share_phat_son_05_2021.jpg',
        ],
        // Open Graph configs
        'og' => [
            'section' => 'Gaming',
            'tag' => 'Võ Lâm Trung Nguyên'
        ]
    ],
    'models'   => [
        'user_model_class'    => 'App\User',
        'payment_model_class' => 'T2G\Common\Models\Payment',
    ],
    'game_api' => [
        'base_url'         => env('GAME_API_BASE_URL'),
        'timeout'          => 30, // seconds
        'api_key'          => env('GAME_API_KEY'),
        'legacy'           => false,
        'is_mocked'        => env('GAME_API_MOCK', true),
        'maintenance_time' => [
            'start' => 1620, // in int format, see CCURepository::getMinCCUForReport
            'end'   => 1710,
        ],
    ],
    'payment'  => [
        'card_payment_partner'        => env(
            'CARD_PAYMENT_PARTNER',
            \T2G\Common\Contract\CardPaymentInterface::PARTNER_RECARD
        ),
        'card_payment_mocked'         => env('CARD_PAYMENT_API_MOCK', true),
        'card_payment_partner_pos2'   => env(
            'CARD_PAYMENT_PARTNER_POS2',
            \T2G\Common\Services\NapTheNhanhPayment::class
        ),
        'recard'                      => [
            'merchant_id' => env('RECARD_MERCHANT_ID'),
            'secret_key'  => env('RECARD_SECRET_KEY'),
        ],
        'napthenhanh'                 => [
            'partner_id'  => env('NAPTHENHANH_PARTNER_ID'),
            'partner_key' => env('NAPTHENHANH_PARTNER_KEY'),
        ],
        'banking_account_dong_a'      => env('BANKING_ACCOUNT_DONGA'),
        'banking_account_vietcombank' => env('BANKING_ACCOUNT_VIETCOMBANK'),
        // tỉ lệ quy đổi vàng từ VND
        'game_gold'                   => [
            'exchange_rate' => 1000, // $gold = round($money / {exchange_rate})
            'bonus_rate'    => 20, // $bonusGold = ceil($gold * {bonus_rate} / 100)
        ],
        // tỉ lệ chia lợi nhuận cho đối tác (%)
        'revenue_rate'                => [
            'recard'      => 32,
            'napthenhanh' => 32,
            'zing'        => 30,
        ],
        'skip_cashout_alert' => false,
    ],
    'momo'     => [
        'mailbox' => 'momo_mailbox', // mailbox name as configured in webklex/laravel-imap package config file
    ],
    'discord'  => [
        'webhooks' => [
            // thông báo giao dịch từ email (MoMo), SMS webhook
            'payment_alert' => env('DISCORD_PAYMENT_ALERT_WEBHOOK_URL'),
            // thông báo khi QTV add vàng từ admincp
            'add_gold'      => env('DISCORD_ADD_GOLD_WEBHOOK_URL'),
            'police'        => env('DISCORD_POLICE_WEBHOOK_URL'),
            'multiple_pc'    => env('DISCORD_MULTIPLE_PC_WEBHOOK_URL'),
            'multiple_login' => env('DISCORD_MULTIPLE_LOGIN_WEBHOOK_URL'),
            'kimyen'         => env('DISCORD_KIMYEN_WEBHOOK_URL'),
            'monitor_gold_trading'  => env('DISCORD_MONITOR_GOLD_TRADING_WEBHOOK_URL'),
            'monitor_gold'          => env('DISCORD_MONITOR_GOLD_WEBHOOK_URL'),
            'monitor_gold_gm'       => env('DISCORD_MONITOR_GOLD_GM_WEBHOOK_URL'),
            'monitor_money_trading' => env('DISCORD_MONITOR_MONEY_TRADING_WEBHOOK_URL'),
            'monitor_shop'          => env('DISCORD_MONITOR_SHOP_WEBHOOK_URL'),
        ],
    ],
    'kibana' => [
        'elasticsearch_config' => [
            'hosts' => [
                '167.71.206.77:9200'
            ],
            'handler' => \Elasticsearch\ClientBuilder::singleHandler()
        ],
        'index_suffix' => '_c02*'
    ],
    'jx_monitor' => [
//        'multi_login_excluded_accounts' => [],
        'multi_login_excluded_accounts' => ['admin01', 'admin02', 'sgns01', 'sgns02', 'sgns03', 'sgns04', 'sgns05', 'sgns06', 'sgns07', 'sgns08', 'sgns09', 'sgns10', 'sgns11', 'sgns12', 'sgns13', 'sgns14', 'sgns15', 'sgns16', 'sgns17', 'sgns18', 'sgns19', 'sgns20', 'sgns21', 'sgns22', 'sgns23', 'sgns24', 'sgns25', 'sgns26', 'sgns27', 'sgns28', 'sgns29', 'sgns30', 'sgns31', 'sgns32', 'sgns33', 'sgns34', 'sgns35', 'babykums01', 'babykums02', 'babykums03', 'babykums04', 'babykums05', 'babykums06', 'babykums07', 'babykums08', 'babykums09', 'babykums10', 'babykums11', 'babykums12', 'babykums13', 'babykums14', 'babykums15', 'babykums16', 'babykums17', 'babykums18', 'babykums19', 'babykums20', 'babykums21', 'babykums22', 'babykums23', 'babykums24', 'babykums25', 'babykums26', 'babykums27', 'babykums28', 'babykums29', 'babykums30', 'babykums31', 'babykums32', 'babykums33', 'babykums34', 'babykums35', 'baongocs01', 'baongocs02', 'baongocs03', 'baongocs04', 'baongocs05', 'baongocs06', 'baongocs07', 'baongocs08', 'baongocs09', 'baongocs10', 'baongocs11', 'baongocs12', 'baongocs13', 'baongocs14', 'baongocs15', 'baongocs16', 'baongocs17', 'baongocs18', 'baongocs19', 'baongocs20','baongocs21','baongocs22','baongocs23','baongocs24','baongocs25','baongocs26','baongocs27','baongocs28','baongocs29','baongocs30','baongocs31','baongocs32','baongocs33','baongocs34','baongocs35','baongocs36','baongocs37','baongocs38','baongocs39','baongocs40'],
        'multiple_pc_pm_excluded_accounts' => ['baongocs01', 'baongocs02', 'baongocs03', 'baongocs04', 'baongocs05', 'baongocs06', 'baongocs07', 'baongocs08', 'baongocs09', 'baongocs10', 'baongocs11', 'baongocs12', 'baongocs13', 'baongocs14', 'baongocs15', 'baongocs16', 'baongocs17', 'baongocs18', 'baongocs19', 'baongocs20','baongocs21','baongocs22','baongocs23','baongocs24','baongocs25','baongocs26','baongocs27','baongocs28','baongocs29','baongocs30','baongocs31','baongocs32','baongocs33','baongocs34','baongocs35','baongocs36','baongocs37','baongocs38','baongocs39','baongocs40']
    ],
    'features' => [
        'post_grouping_enabled' => true
    ],
];
