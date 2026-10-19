<?php

namespace App\Enums;

enum CardType: string
{
    case Silver = 'silver';
    case Gold = 'gold';

    public function label(): string
    {
        return match ($this) {
            self::Silver => 'VIP Silver',
            self::Gold => 'VIP Gold',
        };
    }

    public function labelAr(): string
    {
        return match ($this) {
            self::Silver => 'فضية VIP',
            self::Gold => 'ذهبية VIP',
        };
    }

    public function price(): float
    {
        return config("vip.card_types.{$this->value}.price", 0);
    }

    public function benefits(): array
    {
        return config("vip.card_types.{$this->value}.benefits", []);
    }

    public function color(): string
    {
        return config("vip.card_types.{$this->value}.color", '#D4AF37');
    }
}
