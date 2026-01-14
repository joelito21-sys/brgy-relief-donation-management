<?php

$customGuards = require __DIR__.'/auth_guards.php';

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => array_merge([
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'donor' => [
            'driver' => 'session',
            'provider' => 'donors',
        ],
        'resident' => [
            'driver' => 'session',
            'provider' => 'residents',
        ],
    ], $customGuards['guards']),

    'providers' => array_merge([
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'donors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Donor::class,
        ],
        'residents' => [
            'driver' => 'eloquent',
            'model' => App\Models\Resident::class,
        ],
    ], $customGuards['providers']),

    'passwords' => array_merge([
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'donors' => [
            'provider' => 'donors',
            'table' => 'donor_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'residents' => [
            'provider' => 'residents',
            'table' => 'resident_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ], $customGuards['passwords']),

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
