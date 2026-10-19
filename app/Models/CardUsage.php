<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardUsage extends Model
{
    protected $fillable = [
        'vip_card_id',
        'recorded_by',
        'service_type',
        'cost',
        'notes',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'cost'    => 'decimal:2',
    ];

    public function card()
    {
        return $this->belongsTo(VipCard::class, 'vip_card_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}