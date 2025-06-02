<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    */
    'default' => env('PAYMENT_GATEWAY', 'stripe'),

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    */
    'gateways' => [
        'stripe' => [
            'public_key' => env('STRIPE_PUBLIC_KEY'),
            'secret_key' => env('STRIPE_SECRET_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'currency' => env('STRIPE_CURRENCY', 'usd'),
        ],

        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'sandbox' => env('PAYPAL_SANDBOX', true),
            'currency' => env('PAYPAL_CURRENCY', 'USD'),
        ],

        'gcash' => [
            'merchant_id' => env('GCASH_MERCHANT_ID'),
            'secret_key' => env('GCASH_SECRET_KEY'),
            'sandbox' => env('GCASH_SANDBOX', true),
            'currency' => 'PHP',
        ],

        'paymaya' => [
            'public_key' => env('PAYMAYA_PUBLIC_KEY'),
            'secret_key' => env('PAYMAYA_SECRET_KEY'),
            'sandbox' => env('PAYMAYA_SANDBOX', true),
            'currency' => 'PHP',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */
    'settings' => [
        'tax_rate' => env('TAX_RATE', 0.12), // 12% VAT in Philippines
        'shipping_fee' => env('SHIPPING_FEE', 50.00),
        'free_shipping_threshold' => env('FREE_SHIPPING_THRESHOLD', 1000.00),
        'currency_symbol' => env('CURRENCY_SYMBOL', '₱'),
        'decimal_places' => env('DECIMAL_PLACES', 2),
    ],
];