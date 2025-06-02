<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Store Information
    |--------------------------------------------------------------------------
    */
    'store' => [
        'name' => env('STORE_NAME', 'Possibilitea'),
        'address' => env('STORE_ADDRESS', '123 Tea Street, Manila, Philippines'),
        'phone' => env('STORE_PHONE', '+63 912 345 6789'),
        'email' => env('STORE_EMAIL', 'info@possibilitea.com'),
        'website' => env('STORE_WEBSITE', 'https://possibilitea.com'),
        'logo' => env('STORE_LOGO', '/images/logo.png'),
        'tax_id' => env('STORE_TAX_ID', 'TIN-123-456-789'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Receipt Settings
    |--------------------------------------------------------------------------
    */
    'receipt' => [
        'width' => env('RECEIPT_WIDTH', 80), // characters
        'header_text' => env('RECEIPT_HEADER', 'Thank you for your purchase!'),
        'footer_text' => env('RECEIPT_FOOTER', 'Visit us again soon!'),
        'print_logo' => env('RECEIPT_PRINT_LOGO', true),
        'print_qr_code' => env('RECEIPT_PRINT_QR_CODE', true),
        'auto_print' => env('RECEIPT_AUTO_PRINT', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Inventory Settings
    |--------------------------------------------------------------------------
    */
    'inventory' => [
        'low_stock_threshold' => env('LOW_STOCK_THRESHOLD', 10),
        'out_of_stock_threshold' => env('OUT_OF_STOCK_THRESHOLD', 0),
        'auto_update_stock' => env('AUTO_UPDATE_STOCK', true),
        'track_expiry_dates' => env('TRACK_EXPIRY_DATES', true),
        'allow_negative_stock' => env('ALLOW_NEGATIVE_STOCK', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sales Settings
    |--------------------------------------------------------------------------
    */
    'sales' => [
        'default_customer' => env('DEFAULT_CUSTOMER_ID', 1),
        'allow_partial_payments' => env('ALLOW_PARTIAL_PAYMENTS', true),
        'require_customer_info' => env('REQUIRE_CUSTOMER_INFO', false),
        'enable_discounts' => env('ENABLE_DISCOUNTS', true),
        'max_discount_percent' => env('MAX_DISCOUNT_PERCENT', 50),
        'enable_loyalty_points' => env('ENABLE_LOYALTY_POINTS', true),
        'points_per_peso' => env('POINTS_PER_PESO', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Settings
    |--------------------------------------------------------------------------
    */
    'backup' => [
        'auto_backup' => env('AUTO_BACKUP', true),
        'backup_frequency' => env('BACKUP_FREQUENCY', 'daily'), // daily, weekly, monthly
        'backup_retention_days' => env('BACKUP_RETENTION_DAYS', 30),
        'backup_location' => env('BACKUP_LOCATION', 'local'), // local, s3, dropbox
    ],
];