<?php

return [
    'net' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'timeout' => 100,
        'db' => 2
    ],

    'cache' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'timeout' => 100,
        'db' => 3
    ],

    'sentinel' => [
        [
            'host' => '127.0.0.1',
            'port' => 26379
        ],
        [
            'host' => '127.0.0.1',
            'port' => 26380
        ],
        [
            'host' => '127.0.0.1',
            'port' => 26381
        ]
    ]
];