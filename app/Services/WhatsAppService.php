<?php

namespace App\Services;

use App\Models\VipCard;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function send(string $phone, string $message): bool
    {
        $provider = config('services.whatsapp.provider', env('WHATSAPP_PROVIDER', 'log'));

        if ($provider === 'log' || app()->environment('local')) {
            Log::info("WhatsApp to {$phone}: {$message}");

            return true;
        }

        if ($provider === 'meta') {
            return $this->sendViaMeta($phone, $message);
        }

        Log::warning("Unknown WhatsApp provider: {$provider}");

        return false;
    }

    public function sendCardLink(VipCard $card): bool
    {
        $customer = $card->customer;
        $message = sprintf(
            "مرحباً %s،\n\nبطاقتك VIP جاهزة!\nالنوع: %s\nرقم العضوية: %s\n\nعرض البطاقة: %s\nتحميل PDF: %s",
            $customer->name,
            $card->card_type->labelAr(),
            $card->membership_number,
            $card->qrUrl(),
            route('cards.pdf', $card)
        );

        return $this->send($customer->phone, $message);
    }

    public function getShareUrl(string $phone, string $message): string
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        return 'https://wa.me/'.$cleanPhone.'?text='.urlencode($message);
    }

    private function sendViaMeta(string $phone, string $message): bool
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');

        $response = Http::withToken($token)
            ->post("https://graph.facebook.com/v18.0/{$phoneId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => preg_replace('/[^0-9]/', '', $phone),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

        return $response->successful();
    }
}
