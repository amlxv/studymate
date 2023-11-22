<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TelegramSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $apiKey;
    protected string $baseUrl;
    protected string $apiUrl;
    protected string $chatId;
    protected string $message;

    /**
     * Create a new job instance.
     */
    public function __construct(string $chatId, string $message)
    {
        $this->apiKey = config("services.telegram.client_secret");
        $this->baseUrl = "https://api.telegram.org/bot";
        $this->apiUrl = $this->baseUrl . $this->apiKey . "/sendMessage";
        $this->chatId = $chatId;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Http::asForm()->post($this->apiUrl, [
            "chat_id" => $this->chatId,
            "text" => $this->message
        ]);
    }
}
