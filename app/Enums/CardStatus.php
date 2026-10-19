<?php

namespace App\Enums;

enum CardStatus: string
{
    case Active = 'active';
    case Expired = 'expired';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'فعالة',
            self::Expired => 'منتهية',
            self::Cancelled => 'ملغاة',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'bg-success',
            self::Expired => 'bg-warning text-dark',
            self::Cancelled => 'bg-danger',
        };
    }
}
