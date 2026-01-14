<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backup Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the backup configuration for your application.
    | You can configure automatic backups, schedules, and retention policies.
    |
    */

    // Enable automatic backups
    'auto_backup' => env('BACKUP_AUTO', true),
    
    // Backup schedule (daily, weekly, monthly)
    'schedule' => env('BACKUP_SCHEDULE', 'daily'),
    
    // Number of days to keep backups
    'retention_days' => env('BACKUP_RETENTION_DAYS', 30),

    // Backup destination (local, s3, etc.)
    'destination' => env('BACKUP_DESTINATION', 'local'),

    // Backup source (which directories to backup)
    'source' => [
        'files' => [
            base_path(),
        ],
        'databases' => [
            'mysql',
        ],
    ],

    // Exclude files/directories from backup
    'exclude' => [
        base_path('vendor'),
        base_path('node_modules'),
        storage_path('app/backup-temp'),
    ],
];
