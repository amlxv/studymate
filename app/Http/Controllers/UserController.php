<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function hitBasePath()
    {
        $user = Auth::user();
        return !$user ? $this->handleGuest() : $this->handleUser($user);
    }

    /**
     * @return Response
     */
    public function handleGuest()
    {
        return Inertia::render('Guest/Index');
    }

    public function handleUser(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($user->isAdmin()) {
            return Inertia::render('Admin/Home/Index');
        }

        if ($user->isStudent()) {
            return $this->userDashboard($user);
        }

        abort(404);
    }

    /**
     * Managing the events that will be occurred
     * in that day.
     *
     * @return Response
     */
    public function upcoming()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $upcomingEvents = Schedule::query()
            ->today(Auth::id())
            ->get();

        $upcomingEvents = collect($upcomingEvents)
            ->filter(fn($item) => $item['time_start'] >= now()->format("H:i"));

        return Inertia::render('Student/Upcoming/Index', [
            "upcomingEvents" => $upcomingEvents
        ]);
    }

    public function userDashboard($user)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $classes = Schedule::query()
            ->ofType("class")
            ->thatBelongsTo($user->id)
            ->get()
            ->toArray();

        /** @noinspection PhpUndefinedMethodInspection */
        $activities = Schedule::query()
            ->ofType("activity")
            ->thatBelongsTo($user->id)
            ->get()
            ->toArray();

        $schedules = collect(["classes" => $classes])->merge(["activities" => $activities]);

        return Inertia::render('Student/Home/Index', [
            "schedules" => $schedules,
            "schedulesStatistics" => $this->getSchedulesStatistics(),
        ]);
    }

    public function getSchedulesStatistics()
    {
        $currentYear = Carbon::now()->year;

        $schedules = Schedule::all();
        $classes = $schedules->filter(fn($schedule) => $schedule->type == "class");
        $activities = $schedules->filter(fn($schedule) => $schedule->type == "activity");

        $activitiesCountByMonth = [];
        $activitiesWithReminderCountByMonth = [];
        $classesCountByMonth = [];
        $classesWithReminderCountByMonth = [];

        $months = CarbonPeriod::create($currentYear . '-01', '1 month', $currentYear . '-12')->toArray();

        $months = array_map(function ($m) {
            return Str::lower($m->format('M'));
        }, $months);

        collect($months)
            ->each(function ($month)
            use (
                &$activitiesCountByMonth, &$activitiesWithReminderCountByMonth,
                &$classesCountByMonth, &$classesWithReminderCountByMonth
            ) {
                $activitiesCountByMonth[$month] = 0;
                $activitiesWithReminderCountByMonth[$month] = 0;
                $classesCountByMonth[$month] = 0;
                $classesWithReminderCountByMonth[$month] = 0;
            });

        collect($months)
            ->each(function ($month)
            use (
                $currentYear, $months, $classes,
                &$classesCountByMonth, &$classesWithReminderCountByMonth
            ) {
                $currentMonth = array_keys($months, $month)[0] + 1;
                $currentEndOfMonth = Carbon::parse($month)->endOfMonth()->format('d');
                $template = $currentYear . '-' . $currentMonth . '-';

                $firstDayOfMonth = $template . '01';
                $lastDayOfMonth = $template . $currentEndOfMonth;

                CarbonPeriod::between($firstDayOfMonth, $lastDayOfMonth)
                    ->forEach(function ($day)
                    use (
                        $classes, $month,
                        &$classesCountByMonth, &$classesWithReminderCountByMonth
                    ) {
                        $classesCountByMonth[$month] += $classes
                            ->filter(fn($class) => $class->day == Str::lower($day->dayName))
                            ->count();

                        $classesWithReminderCountByMonth[$month] += $classes
                            ->filter(fn($class) => $class->day == Str::lower($day->dayName) && $class->remind)
                            ->count();
                    });
            });

        $activities->each(function ($activity) use (&$activitiesCountByMonth, &$activitiesWithReminderCountByMonth) {
            $monthName = Str::lower(Carbon::createFromDate($activity->date)->format('M'));
            $activitiesCountByMonth[$monthName] += 1;

            if ($activity->remind) {
                $activitiesWithReminderCountByMonth[$monthName] += 1;
            }
        });

        return collect([
            'classes' => $classesCountByMonth,
            'classesRemind' => $classesWithReminderCountByMonth,
            'activities' => $activitiesCountByMonth,
            'activitiesRemind' => $activitiesWithReminderCountByMonth,
        ])->toArray();
    }
}
