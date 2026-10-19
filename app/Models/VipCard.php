<?php

namespace App\Models;

use App\Enums\CardStatus;
use App\Enums\CardType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'membership_number',
        'card_type',
        'price',
        'status',
        'issued_at',
        'expires_at',
        'qr_token',
        'issued_by',
        'renewed_at',
        'cancelled_at',
        'cancelled_reason',
    ];

    protected function casts(): array
    {
        return [
            'card_type' => CardType::class,
            'status' => CardStatus::class,
            'price' => 'decimal:2',
            'issued_at' => 'datetime',
            'expires_at' => 'datetime',
            'renewed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function isActive(): bool
    {
        return $this->status === CardStatus::Active && $this->expires_at->isFuture();
    }

    public function effectiveStatus(): CardStatus
    {
        if ($this->status === CardStatus::Cancelled) {
            return CardStatus::Cancelled;
        }

        if ($this->expires_at->isPast()) {
            return CardStatus::Expired;
        }

        return $this->status;
    }

    public function qrUrl(): string
    {
        return url('/card/'.$this->qr_token);
    }

    public function benefits(): array
    {
        return $this->card_type->benefits();
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('membership_number', 'like', "%{$term}%")
                ->orWhereHas('customer', fn ($c) => $c->search($term));
        });
    }
     public function usages()
{
            return $this->hasMany(CardUsage::class)->latest('used_at');
        }
}
