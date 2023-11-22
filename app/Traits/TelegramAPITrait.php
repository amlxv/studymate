<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait TelegramAPITrait
{
    protected static string $apiKey;
    protected static string $baseUrl;
    protected static string $apiUrl;

    public function __construct()
    {
        self::$apiKey = config("services.telegram.client_secret");
        self::$baseUrl = "https://api.telegram.org/bot";
        self::$apiUrl = self::$baseUrl . self::$apiKey . "/";
    }

    /**
     * Send message to user
     * using Telegram Bot
     *
     * @param $chat_id
     * @param $message
     * @return bool
     */
    public static function sendMessage($chat_id, $message): bool
    {
        $methodId = "sendMessage";
        $formData = [
            "chat_id" => $chat_id,
            "text" => $message
        ];

        if (Http::asForm()->post(self::$apiUrl . $methodId, $formData)->ok()) {
            return true;
        }

        return false;
    }
}
