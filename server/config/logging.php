<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    */
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    */
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    */
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        // Custom channels for POS system
        'pos_transactions' => [
            'driver' => 'daily',
            'path' => storage_path('logs/pos-transactions.log'),
            'level' => 'info',
            'days' => 90,
        ],

        'inventory_changes' => [
            'driver' => 'daily',
            'path' => storage_path('logs/inventory.log'),
            'level' => 'info',
            'days' => 90,
        ],

        'payment_logs' => [
            'driver' => 'daily',
            'path' => storage_path('logs/payments.log'),
            'level' => 'info',
            'days' => 365, // Keep payment logs for 1 year
        ],

        'security' => [
            'driver' => 'daily',
            'path' => storage_path('logs/security.log'),
            'level' => 'warning',
            'days' => 365,
        ],
    ],
];
