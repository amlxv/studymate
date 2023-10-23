<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();

        $userId = Auth::id();

        /** @noinspection PhpUndefinedMethodInspection */
        $classes = Schedule::query()
            ->ofType("class")
            ->thatBelongsTo($userId)
            ->get()
            ->toArray();

        /** @noinspection PhpUndefinedMethodInspection */
        $activities = Schedule::query()
            ->ofType("activity")
            ->thatBelongsTo($userId)
            ->whereMonth('date', '=', $now->month)
            ->orderBy('date')
            ->orderBy('time_start')
            ->get()
            ->toArray();

        $from = Carbon::now()->firstOfMonth();
        $to = Carbon::now()->endOfMonth();
        $period = CarbonPeriod::create($from, $to);

        foreach ($period as $date) {
            $day = Str::lower($date->format('l'));
            $classSchedules = collect($classes)->where('day', '=', $day)->toArray();
            $activitySchedules = collect($activities)->where('date', '=', $date->format('Y-m-d'))->toArray();

            $todaySchedules = [
                'date' => $date->format("Y-m-d"),
                'day' => $day,
                'isToday' => $date->isToday(),
                'events' => collect($classSchedules)
                    ->merge($activitySchedules)
                    ->sortBy('time_start')
                    ->values()
                    ->all(),
            ];

            $schedules[] = $todaySchedules;
        }

        return Inertia::render('Student/Schedule/Index', ["schedules" => $schedules ?? null]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Student/Schedule/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $userId = ['user_id' => $request->user()->id];
        $schedule = $this->filterRequest($request);

        if (Schedule::query()->create($schedule->merge($userId)->toArray())) {
            return redirect()->route('schedule.index')
                ->with(["status" => "A new schedule has been created!"]);
        }

        return back()->with([
            'status' => ['error' => 'Something went wrong when creating a new schedule.']
        ]);

        // TODO: Check if the schedule is today's upcoming event, then add this schedule to the events table too.
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        if ($schedule['user_id'] != Auth::id()) {
            return redirect()->route('schedule.index')
                ->with(["status" => ["warning" => "The schedule is not belongs to you."]]);
        }

        return Inertia::render("Student/Schedule/Edit", ["schedule" => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreScheduleRequest $request, Schedule $schedule)
    {
        if ($schedule['user_id'] != Auth::id()) abort('403');

        $data = $this->filterRequest($request)->all();

        if ($schedule->update($data)) {
            return redirect()->route('schedule.index')->with(["status" => "The schedule has been updated!"]);
        }

        return back()->with(['status' => ['error' => 'Something went wrong when updating the schedule.']]);

        // TODO: Check if the schedule is today's upcoming event, then add this schedule to the events table too.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        if (!$schedule->delete()) {
            return back()->with(["status" => ["error" => "Something went wrong when deleting the schedule."]]);
        }

        return back()->with(['status' => "The schedule has been deleted."]);
    }

    /**
     * Filter the required information based on the type.
     */
    public function filterRequest(StoreScheduleRequest $request): Collection
    {
        switch ($request['type']) {
            case 'class':
                return collect($request)->except('date');

            case 'activity':
                return collect($request)->except('day');
        }

        abort('422');
    }

    /**
     * Show all the schedules
     */
    public function viewAll(Request $request)
    {
        $userId = Auth::id();

        /** @noinspection PhpUndefinedMethodInspection */
        $classes = Schedule::query()
            ->ofType("class")
            ->ofDay($request)
            ->search($request)
            ->thatBelongsTo($userId)
            ->paginate(15);

        /** @noinspection PhpUndefinedMethodInspection */
        $activities = Schedule::query()
            ->ofType("activity")
            ->ofMonth($request)
            ->search($request)
            ->thatBelongsTo($userId)
            ->paginate(15);

        return Inertia::render('Student/Schedule/All', [
            "classes" => $classes,
            'activities' => $activities
        ]);
    }
}
