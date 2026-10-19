<?php

namespace App\Enums;

enum MessageChannel: string
{
    case Sms = 'sms';
    case Whatsapp = 'whatsapp';
    case Both = 'both';

    public function label(): string
    {
        return match ($this) {
            self::Sms => 'SMS',
            self::Whatsapp => 'WhatsApp',
            self::Both => 'SMS + WhatsApp',
        };
    }
}
