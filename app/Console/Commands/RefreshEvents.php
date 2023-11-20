<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Traits\EventTrait;

class RefreshEvents extends Command
{
    use EventTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-seed the events table.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = Carbon::now();
        $currentDayName = Str::lower($now->dayName);
        $currentDate = $now->format("Y-m-d");
        $currentTime = $now->format("H:i:s");

        $schedules = Schedule::query()
            ->where("remind", "=", true)
            ->where("time_start", ">", $currentTime)
            ->where(function (Builder $query) use ($currentDate, $currentDayName) {
                $query->where("day", "=", $currentDayName)
                    ->orWhere("date", "=", $currentDate);
            })
            ->get();

        $events = collect($schedules)
            ->map(fn($schedule) => $this->getEventDataFromSchedule($schedule))
            ->filter(fn($item) => $item)
            ->toArray();

        $this->refreshEvent($events);
    }
}
