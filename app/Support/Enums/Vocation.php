<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;
use Filament\Support\Contracts\HasIcon;

enum Vocation: string implements HasIcon
{
    use ArrayableEnum;

    case None = 'None';
    case Druid = 'Druid';
    case Sorcerer = 'Sorcerer';
    case Paladin = 'Paladin';
    case Knight = 'Knight';
    case ElderDruid = 'Elder Druid';
    case MasterSorcerer = 'Master Sorcerer';
    case RoyalPaladin = 'Royal Paladin';
    case EliteKnight = 'Elite Knight';

    public function getShortValue(): string
    {
        return preg_replace('/[^A-Z]/', '', $this->value);
    }

    public function getIcon(): string
    {
        return match ($this) {
            Vocation::Druid, Vocation::ElderDruid => 'rpg-leaf',
            Vocation::Sorcerer, Vocation::MasterSorcerer => 'rpg-lightning-bolt',
            Vocation::Paladin, Vocation::RoyalPaladin => 'rpg-target-arrows',
            Vocation::Knight, Vocation::EliteKnight => 'rpg-crossed-swords',
            default => 'heroicon-s-question-mark-circle',
        };
    }
}
