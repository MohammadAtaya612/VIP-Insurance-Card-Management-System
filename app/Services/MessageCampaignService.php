<?php

namespace App\Services;

use App\Enums\CampaignStatus;
use App\Enums\MessageChannel;
use App\Imports\RecipientsImport;
use App\Jobs\ProcessMessageCampaign;
use App\Models\Customer;
use App\Models\MessageCampaign;
use App\Models\MessageLog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class MessageCampaignService
{
    public function create(array $data, User $creator): MessageCampaign
    {
        return MessageCampaign::create([
            'title' => $data['title'],
            'channel' => $data['channel'],
            'message_body' => $data['message_body'],
            'status' => ! empty($data['scheduled_at'])
                ? CampaignStatus::Scheduled
                : CampaignStatus::Draft,
            'source_type' => $data['source_type'] ?? 'customers',
            'scheduled_at' => $data['scheduled_at'] ?? null,
            'created_by' => $creator->id,
        ]);
    }

    public function importRecipients(MessageCampaign $campaign, UploadedFile $file): int
    {
        $path = $file->store('imports', 'local');
        $campaign->update(['import_file' => $path, 'source_type' => 'excel']);

        $import = new RecipientsImport;
        Excel::import($import, $path, 'local');

        $count = 0;
        foreach ($import->getRows() as $row) {
            $this->createLogEntry($campaign, $row['name'], $row['phone'], null);
            $count++;
        }

        $campaign->update(['total_recipients' => $count]);

        return $count;
    }

    public function loadFromCustomers(MessageCampaign $campaign): int
    {
        $customers = Customer::all();
        $count = 0;

        foreach ($customers as $customer) {
            $this->createLogEntry($campaign, $customer->name, $customer->phone, $customer->id);
            $count++;
        }

        $campaign->update([
            'total_recipients' => $count,
            'source_type' => 'customers',
        ]);

        return $count;
    }

    public function dispatch(MessageCampaign $campaign): void
    {
        $campaign->update([
            'status' => CampaignStatus::Processing,
            'started_at' => now(),
        ]);

        ProcessMessageCampaign::dispatch($campaign);
    }

    public function schedule(MessageCampaign $campaign): void
    {
        $campaign->update(['status' => CampaignStatus::Scheduled]);
        ProcessMessageCampaign::dispatch($campaign)->delay($campaign->scheduled_at);
    }

    private function createLogEntry(
        MessageCampaign $campaign,
        string $name,
        string $phone,
        ?int $customerId
    ): void {
        $channels = match ($campaign->channel) {
            MessageChannel::Sms => [MessageChannel::Sms],
            MessageChannel::Whatsapp => [MessageChannel::Whatsapp],
            MessageChannel::Both => [MessageChannel::Sms, MessageChannel::Whatsapp],
        };

        foreach ($channels as $channel) {
            MessageLog::create([
                'campaign_id' => $campaign->id,
                'customer_id' => $customerId,
                'recipient_name' => $name,
                'recipient_phone' => $phone,
                'channel' => $channel,
                'status' => 'pending',
            ]);
        }
    }
}
