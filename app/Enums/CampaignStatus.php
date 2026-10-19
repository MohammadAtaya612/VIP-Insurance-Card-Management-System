<?php

namespace App\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Processing = 'processing';
    case Completed = 'completed';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'مسودة',
            self::Scheduled => 'مجدولة',
            self::Processing => 'قيد الإرسال',
            self::Completed => 'مكتملة',
            self::Failed => 'فاشلة',
            self::Cancelled => 'ملغاة',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'bg-secondary',
            self::Scheduled => 'bg-info',
            self::Processing => 'bg-primary',
            self::Completed => 'bg-success',
            self::Failed => 'bg-danger',
            self::Cancelled => 'bg-dark',
        };
    }
}
