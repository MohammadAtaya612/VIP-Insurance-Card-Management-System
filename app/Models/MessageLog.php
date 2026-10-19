<?php

namespace App\Models;

use App\Enums\MessageChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'customer_id',
        'recipient_name',
        'recipient_phone',
        'channel',
        'status',
        'error_message',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'channel' => MessageChannel::class,
            'sent_at' => 'datetime',
        ];
    }

    public function campaign()
    {
        return $this->belongsTo(MessageCampaign::class, 'campaign_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
