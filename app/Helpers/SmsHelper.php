<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsHelper
{
    public static function send($receptor, $message)
    {
        $apiKey = env('KAVEHNEGAR_API_KEY');
        $sender = env('KAVEHNEGAR_SENDER');

        $response = Http::asForm()->post("https://api.kavenegar.com/v1/{$apiKey}/sms/send.json", [
            'receptor' => $receptor,
            'sender'   => $sender,
            'message'  => $message,
        ]);

        if ($response->failed()) {
            Log::error('خطا در ارسال پیامک کاوه نگار: ' . $response->body());
        }

        return $response->json();
    }
}
