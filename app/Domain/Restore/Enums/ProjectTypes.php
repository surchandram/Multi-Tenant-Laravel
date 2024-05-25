<?php

namespace SAAS\Domain\Restore\Enums;

enum ProjectTypes: string
{
    case Cleaning = 'cleaning';
    case Fire = 'fire';
    case Mitigation = 'mitigation';
    case Mold = 'mold';
    case Sewage = 'sewage';
    case Water = 'water';

    public function label()
    {
        return match ($this) {
            self::Cleaning => 'Cleaning',
            self::Fire => 'Fire',
            self::Mitigation => 'Mitigation',
            self::Mold => 'Mold',
            self::Sewage => 'Sewage',
            self::Water => 'Water',
        };
    }

    /**
     * Get project types as an array for forms.
     *
     * @return array
     */
    public static function asFormObject()
    {
        return collect(ProjectTypes::cases())
            ->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()])
            ->all();
    }
}
