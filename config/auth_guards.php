<?php

return [
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'resident' => [
            'driver' => 'session',
            'provider' => 'residents',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'donors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Donor::class,
        ],
        'residents' => [
            'driver' => 'eloquent',
            'model' => App\Models\Resident::class,
        ],
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'donors' => [
            'provider' => 'donors',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'residents' => [
            'provider' => 'residents',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
