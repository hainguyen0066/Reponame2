<?php

return [
    'asset' => [
        'version' => '201909251400'
    ],
    'site'     => [
        'domains' => ['vltrungnguyen.com', 'www.vltrungnguyen.com', 'vltrungnguyen.net', 'www.vltrunglnguyen.net'],
        'seo'     => [
            'title'            => 'Võ Lâm Trung Nguyên',
            'meta_keyword'     => 'vo lam trung nguyen, vltk hay, game pk hay, volam1, ctc, vo lam ctc, vo lam cong thanh chien, vo lam 1',
            'meta_description' => 'Ôn lại hồi ức thời hoàng kim của võ lâm. Lộ trình phát triển rõ ràng, update tính năng liên tục và đều đặn.',
            'meta_image'       => 'images/share.1.5.jpg',
        ],
    ],
    'models'   => [
        'user_model_class'    => 'App\User',
        'payment_model_class' => 'T2G\Common\Models\Payment',
    ],
    'game_api' => [
        'base_url'  => env('GAME_API_BASE_URL'),
        'api_key'   => env('GAME_API_KEY'),
        'is_mocked' => env('GAME_API_MOCK', true),
    ],
    'payment'  => [
        'card_payment_partner'        => env(
            'CARD_PAYMENT_PARTNER',
            \T2G\Common\Contract\CardPaymentInterface::PARTNER_RECARD
        ),
        'card_payment_mocked'         => env('CARD_PAYMENT_API_MOCK', true),
        'card_payment_partner_pos2'   => env(
            'CARD_PAYMENT_PARTNER_POS2',
            \T2G\Common\Contract\CardPaymentInterface::PARTNER_NAPTHENHANH
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
        ],
    ],
];
