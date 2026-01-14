<?php

namespace App\Enums;

enum PwdClassification: string
{
    case VISUAL_IMPAIRMENT = 'visual_impairment';
    case HEARING_IMPAIRMENT = 'hearing_impairment';
    case ORTHOPEDIC_IMPAIRMENT = 'orthopedic_impairment';
    case INTELLECTUAL_DISABILITY = 'intellectual_disability';
    case MENTAL_HEALTH_CONDITION = 'mental_health_condition';
    case CHRONIC_ILLNESS = 'chronic_illness';
    case LEARNING_DISABILITY = 'learning_disability';
    case SPEECH_IMPAIRMENT = 'speech_impairment';
    case MULTIPLE_DISABILITY = 'multiple_disability';
    case OTHER = 'other';

    public static function asArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::VISUAL_IMPAIRMENT => 'Visual Impairment',
            self::HEARING_IMPAIRMENT => 'Hearing Impairment',
            self::ORTHOPEDIC_IMPAIRMENT => 'Orthopedic Impairment',
            self::INTELLECTUAL_DISABILITY => 'Intellectual Disability',
            self::MENTAL_HEALTH_CONDITION => 'Mental Health Condition',
            self::CHRONIC_ILLNESS => 'Chronic Illness',
            self::LEARNING_DISABILITY => 'Learning Disability',
            self::SPEECH_IMPAIRMENT => 'Speech Impairment',
            self::MULTIPLE_DISABILITY => 'Multiple Disability',
            self::OTHER => 'Other',
        };
    }
}
