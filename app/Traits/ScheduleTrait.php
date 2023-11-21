<?php

namespace App\Traits;

use App\Models\Schedule;
use App\Models\Telegram;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait ScheduleTrait
{
    /**
     * Check today schedule.
     *
     * @param Schedule $schedule
     * @return bool
     */
    protected static function isToday(Schedule $schedule): bool
    {
        $now = Carbon::now();
        $currentDayName = Str::lower($now->dayName);
        $currentDate = $now->format("Y-m-d");

        return $schedule->date == $currentDate || $schedule->day == $currentDayName;
    }

    /**
     * Check upcoming schedule in
     * a day.
     *
     * @param Schedule $schedule
     * @return bool
     */
    protected static function isUpcomingToday(Schedule $schedule): bool
    {
        if (static::isToday($schedule)) {
            $currentTime = Carbon::now()->format("H:i:s");
            return $schedule->time_start > $currentTime;
        }

        return false;
    }

    /**
     * Check whether the user already integrate
     * the account to Telegram.
     *
     * @param $userId
     * @return bool
     */
    protected static function verifyTelegramIntegration($userId): bool
    {
        $telegram = Telegram::where("user_id", "=", $userId)->first();
        return (bool)$telegram;
    }
}
