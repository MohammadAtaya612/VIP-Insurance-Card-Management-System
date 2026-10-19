<?php

namespace App\Jobs;

use App\Enums\CampaignStatus;
use App\Enums\MessageChannel;
use App\Models\MessageCampaign;
use App\Models\MessageLog;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMessageCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public function __construct(public MessageCampaign $campaign) {}

    public function handle(SmsService $sms, WhatsAppService $whatsapp): void
    {
        $campaign = $this->campaign->fresh();
        $message = $campaign->message_body;

        MessageLog::where('campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->orderBy('id')
            ->chunkById(100, function ($logs) use ($sms, $whatsapp, $message, $campaign) {
                foreach ($logs as $log) {
                    $success = match ($log->channel) {
                        MessageChannel::Sms => $sms->send($log->recipient_phone, $message),
                        MessageChannel::Whatsapp => $whatsapp->send($log->recipient_phone, $message),
                        default => false,
                    };

                    $log->update([
                        'status' => $success ? 'sent' : 'failed',
                        'sent_at' => $success ? now() : null,
                        'error_message' => $success ? null : 'فشل الإرسال',
                    ]);

                    if ($success) {
                        $campaign->increment('sent_count');
                    } else {
                        $campaign->increment('failed_count');
                    }
                }
            });

        $campaign->update([
            'status' => CampaignStatus::Completed,
            'completed_at' => now(),
        ]);
    }
}
