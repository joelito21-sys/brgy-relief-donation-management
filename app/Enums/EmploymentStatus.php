<?php

namespace App\Enums;

enum EmploymentStatus: string
{
    case EMPLOYED = 'employed';
    case SELF_EMPLOYED = 'self_employed';
    case UNEMPLOYED = 'unemployed';
    case STUDENT = 'student';
    case RETIRED = 'retired';
    case HOMEMAKER = 'homemaker';
    case DISABLED = 'disabled';
    case OTHER = 'other';

    public static function asArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::EMPLOYED => 'Employed',
            self::SELF_EMPLOYED => 'Self-Employed',
            self::UNEMPLOYED => 'Unemployed',
            self::STUDENT => 'Student',
            self::RETIRED => 'Retired',
            self::HOMEMAKER => 'Homemaker',
            self::DISABLED => 'Disabled',
            self::OTHER => 'Other',
        };
    }
}
