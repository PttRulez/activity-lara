<?php

return [
    'bots' => [
        'invest_bot' => [
            'telegram' => [
                'token' => env('TELEGRAM_INVEST_BOT_TOKEN'),
            ],
        ],
        'test_bot' => [
            'telegram' => [
                'token' => env('TELEGRAM_TEST_BOT_TOKEN'),
            ],
        ],
    ],
];
