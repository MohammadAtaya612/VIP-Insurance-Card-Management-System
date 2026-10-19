<?php

namespace App\Services;

use App\Enums\CardStatus;
use App\Enums\CardType;
use App\Models\Customer;
use App\Models\User;
use App\Models\VipCard;
use Illuminate\Support\Str;

class VipCardService
{
    public function issue(Customer $customer, CardType $type, User $issuer): VipCard
    {
        $validityDays = config('vip.card_validity_days', 365);
        $now = now();

        return VipCard::create([
            'customer_id' => $customer->id,
            'membership_number' => $this->generateMembershipNumber(),
            'card_type' => $type,
            'price' => $type->price(),
            'status' => CardStatus::Active,
            'issued_at' => $now,
            'expires_at' => $now->copy()->addDays($validityDays),
            'qr_token' => Str::random(32),
            'issued_by' => $issuer->id,
        ]);
    }

    public function renew(VipCard $card): VipCard
    {
        $validityDays = config('vip.card_validity_days', 365);
        $baseDate = $card->expires_at->isFuture() ? $card->expires_at : now();

        $card->update([
            'status' => CardStatus::Active,
            'expires_at' => $baseDate->copy()->addDays($validityDays),
            'renewed_at' => now(),
            'cancelled_at' => null,
            'cancelled_reason' => null,
        ]);

        return $card->fresh();
    }

    public function cancel(VipCard $card, ?string $reason = null): VipCard
    {
        $card->update([
            'status' => CardStatus::Cancelled,
            'cancelled_at' => now(),
            'cancelled_reason' => $reason,
        ]);

        return $card->fresh();
    }

    public function expireOverdueCards(): int
    {
        return VipCard::where('status', CardStatus::Active)
            ->where('expires_at', '<', now())
            ->update(['status' => CardStatus::Expired]);
    }

    private function generateMembershipNumber(): string
    {
        $prefix = config('vip.membership_prefix', 'VIP');
        $year = now()->format('Y');
        $lastCard = VipCard::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $sequence = $lastCard
            ? (int) substr($lastCard->membership_number, -6) + 1
            : 1;

        return sprintf('%s-%s-%06d', $prefix, $year, $sequence);
    }
}
