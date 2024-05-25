<?php

namespace SAAS\Domain\Documents\Enums;

enum DocumentType: string
{
    case WorkAuthorization = 'work_authorization';
    case WorkCompletion = 'work_completion';
    case RealeaseFromLiability = 'realease_from_liability';
    case ChemicalRealease = 'chemical_realease';

    public function label(): string
    {
        return match ($this) {
            self::WorkAuthorization => 'Work Authorization',
            self::WorkCompletion => 'Work Completion',
            self::RealeaseFromLiability => 'Realease from Liability',
            self::ChemicalRealease => 'Chemical Realease',
        };
    }

    public static function forSync(string $type)
    {
        return in_array($type, array_keys(self::cases()));
    }
}
