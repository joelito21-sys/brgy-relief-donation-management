<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Account Details
    |--------------------------------------------------------------------------
    |
    | Configure your GCash, PayMaya, and Bank account details here.
    | These will be displayed to donors during the payment process.
    |
    */

    'gcash' => [
        'number' => env('GCASH_NUMBER', '09XX XXX XXXX'),
        'name' => env('GCASH_ACCOUNT_NAME', 'Barangay Cubacub Relief Fund'),
        'enabled' => env('GCASH_ENABLED', true),
    ],

    'paymaya' => [
        'number' => env('PAYMAYA_NUMBER', '09XX XXX XXXX'),
        'name' => env('PAYMAYA_ACCOUNT_NAME', 'Barangay Cubacub Relief Fund'),
        'enabled' => env('PAYMAYA_ENABLED', true),
    ],

    'bank' => [
        'bpi' => [
            'account_name' => env('BPI_ACCOUNT_NAME', 'Barangay Cubacub Relief Fund'),
            'account_number' => env('BPI_ACCOUNT_NUMBER', '1234 5678 9012'),
            'branch' => env('BPI_BRANCH', 'BPI Main Branch'),
            'enabled' => env('BPI_ENABLED', true),
        ],
        'bdo' => [
            'account_name' => env('BDO_ACCOUNT_NAME', 'Barangay Cubacub Relief Fund'),
            'account_number' => env('BDO_ACCOUNT_NUMBER', '9876 5432 1098'),
            'branch' => env('BDO_BRANCH', 'BDO Main Branch'),
            'enabled' => env('BDO_ENABLED', true),
        ],
        'metrobank' => [
            'account_name' => env('METROBANK_ACCOUNT_NAME', 'Barangay Cubacub Relief Fund'),
            'account_number' => env('METROBANK_ACCOUNT_NUMBER', '5678 1234 5678'),
            'branch' => env('METROBANK_BRANCH', 'Metrobank Main Branch'),
            'enabled' => env('METROBANK_ENABLED', true),
        ],
    ],
];
