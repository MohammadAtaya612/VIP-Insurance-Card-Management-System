<?php

namespace App\Models;

use App\Enums\CampaignStatus;
use App\Enums\MessageChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'channel',
        'message_body',
        'status',
        'source_type',
        'import_file',
        'scheduled_at',
        'started_at',
        'completed_at',
        'total_recipients',
        'sent_count',
        'failed_count',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'channel' => MessageChannel::class,
            'status' => CampaignStatus::class,
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs()
    {
        return $this->hasMany(MessageLog::class, 'campaign_id');
    }

    public function progressPercent(): int
    {
        if ($this->total_recipients === 0) {
            return 0;
        }

        return (int) round((($this->sent_count + $this->failed_count) / $this->total_recipients) * 100);
    }
}
