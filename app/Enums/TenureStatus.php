<?php

namespace App\Enums;

enum TenureStatus: string
{
    case OWNER = 'owner';
    case RENTER = 'renter';
    case SHARING = 'sharing';
    case RELATIVE = 'relative';
    case CARETAKER = 'caretaker';
    case OTHER = 'other';

    public static function asArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::OWNER => 'Owner',
            self::RENTER => 'Renter',
            self::SHARING => 'Sharing',
            self::RELATIVE => 'Living with Relative',
            self::CARETAKER => 'Caretaker',
            self::OTHER => 'Other',
        };
    }
}
