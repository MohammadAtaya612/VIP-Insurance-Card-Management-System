<?php

namespace App\Services;

use App\Enums\CardStatus;
use App\Enums\CardType;
use App\Models\Customer;
use App\Models\VipCard;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'customers_count' => Customer::count(),
            'active_cards' => VipCard::where('status', CardStatus::Active)
                ->where('expires_at', '>', now())->count(),
            'expired_cards' => VipCard::where(function ($q) {
                $q->where('status', CardStatus::Expired)
                    ->orWhere(function ($q2) {
                        $q2->where('status', CardStatus::Active)
                            ->where('expires_at', '<=', now());
                    });
            })->count(),
            'silver_cards' => VipCard::where('card_type', CardType::Silver)->count(),
            'gold_cards' => VipCard::where('card_type', CardType::Gold)->count(),
            'total_revenue' => VipCard::where('status', '!=', CardStatus::Cancelled)->sum('price'),
            'recent_cards' => VipCard::with(['customer', 'issuer'])
                ->latest()
                ->limit(10)
                ->get(),
            'monthly_revenue' => $this->monthlyRevenue(),
        ];
    }

    private function monthlyRevenue(): array
    {
        return VipCard::selectRaw('MONTH(issued_at) as month, SUM(price) as total')
            ->whereYear('issued_at', now()->year)
            ->where('status', '!=', CardStatus::Cancelled)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }
}
