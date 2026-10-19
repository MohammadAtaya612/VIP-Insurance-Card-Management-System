<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $phone, string $message): bool
    {
        $provider = config('services.sms.provider', env('SMS_PROVIDER', 'log'));

        if ($provider === 'log' || app()->environment('local')) {
            Log::info("SMS to {$phone}: {$message}");

            return true;
        }

        if ($provider === 'twilio') {
            return $this->sendViaTwilio($phone, $message);
        }

        Log::warning("Unknown SMS provider: {$provider}");

        return false;
    }

    private function sendViaTwilio(string $phone, string $message): bool
    {
        $sid = config('services.sms.twilio_sid');
        $token = config('services.sms.twilio_token');
        $from = config('services.sms.twilio_from');

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $phone,
                'Body' => $message,
            ]);

        return $response->successful();
    }
}
