<?php

namespace App\Enums;

enum CivilStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case DIVORCED = 'divorced';
    case ANNULLED = 'annulled';
    case COHABITING = 'cohabiting';
    case OTHER = 'other';

    public static function asArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::WIDOWED => 'Widowed',
            self::SEPARATED => 'Separated',
            self::DIVORCED => 'Divorced',
            self::ANNULLED => 'Annulled',
            self::COHABITING => 'Cohabiting',
            self::OTHER => 'Other',
        };
    }
}
