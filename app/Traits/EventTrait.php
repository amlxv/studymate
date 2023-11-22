<?php

namespace App\Traits;

use App\Models\Event;
use App\Models\Preference;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

trait EventTrait
{
    public static function getEventDataFromSchedule(Schedule $schedule): ?array
    {
        $userId = $schedule->user_id;
        $scheduleId = $schedule->id;
        $preference = Preference::where("user_id", "=", $userId)->first();
        $preferenceId = null;
        $telegramId = null;
        $minutesBefore = 0;

        if ($preference) {
            $preferenceId = $preference->id;
            $telegramId = $preference->telegram_id;
            $minutesBefore = $preference->time_before;
        }

        $currentTime = Carbon::now()->format("H:i:s");
        $timeStart = $schedule->time_start;
        $carbon = Carbon::parse($timeStart);
        $timeToSend = $carbon->subMinutes($minutesBefore)->toTimeString();

        if (!$telegramId || $currentTime > $timeStart) {
            return null;
        };

        return [
            "user_id" => $userId,
            "schedule_id" => $scheduleId,
            "preference_id" => $preferenceId,
            "telegram_id" => $telegramId,
            "time_to_send" => $timeToSend,
        ];
    }

    public static function refreshEvent(array $events): bool
    {
        Event::query()->truncate();
        
        foreach ($events as $event) {
            if (!Event::query()->create($event)) {
                return false;
            };
        }

        return true;
    }

    public static function addEvent(array $event): bool
    {
        return (bool)Event::query()->create($event);
    }

    public static function updateEvent(int $id, array $event): bool|int
    {
        $eventInstance = Event::query()->find($id);
        return $eventInstance->update($event);
    }

    public static function deleteEvent(int $id)
    {
        return Event::query()->find($id)->delete();
    }
}
