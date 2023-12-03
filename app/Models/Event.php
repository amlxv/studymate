<?php

namespace App\Models;

use App\Jobs\TelegramSendMessage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'timetable_id',
        'preference_id',
        'telegram_id',
        'time_to_send'
    ];

    protected static function booted()
    {
        static::created(fn(Event $event) => static::handleTelegramSendMessageJob($event));
        static::updated(fn(Event $event) => static::handleTelegramSendMessageJob($event));

        parent::booted();
    }

    protected static function handleTelegramSendMessageJob(Event $event): void
    {
        $chatId = $event->telegram->chat_id;
        $schedule = $event->schedule;
        $message = static::getMessage($schedule, $event->preference->custom_message);

        $currentTime = Carbon::parse(Carbon::now()->format("H:i:s"));
        $timeToSend = $event->time_to_send;
        $delay = $currentTime->diffInSeconds($timeToSend) ?? 0;

        TelegramSendMessage::dispatch($chatId, $message)->delay($delay);
    }

    protected static function getMessage(Schedule $schedule, ?string $template): string
    {
        $title = $schedule->title;
        $description = $schedule->description;
        $day = $schedule->day;
        $date = $schedule->date;
        $time_start = $schedule->time_start;
        $time_end = $schedule->time_end ?? '';

        if ($template) {
            return str_replace(["{title}", "{description}", "{day}", "{date}", "{time_start}", "time_end"],
                [$title, $description, $day, $date, $time_start, $time_end],
                $template);
        }

        return "Hi, there! There's upcoming schedule for you. Here's some details:\n\n$title\n\n$description";
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function preference(): BelongsTo
    {
        return $this->belongsTo(Preference::class);
    }

    public function telegram(): BelongsTo
    {
        return $this->belongsTo(Telegram::class);
    }
}
