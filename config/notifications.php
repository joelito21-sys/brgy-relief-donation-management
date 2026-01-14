<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the notification settings for your application.
    | You can enable or disable different types of notifications here.
    |
    */

    // Email notifications
    'email' => env('NOTIFICATIONS_EMAIL', true),
    
    // SMS notifications
    'sms' => env('NOTIFICATIONS_SMS', false),
    
    // Push notifications
    'push' => env('NOTIFICATIONS_PUSH', false),

    // Notification channels
    'channels' => [
        'mail',
        'database',
        // 'nexmo', // Uncomment if using Nexmo for SMS
        // 'slack', // Uncomment if using Slack
    ],
];
