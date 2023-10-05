<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Student/Schedule/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $days = Day::all();
        return Inertia::render('Student/Schedule/Create', ['days' => $days]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            "type" => "in:class,activity",
            "title" => "required",
            "description" => "required",
            "date" => "required_if:type,activity",
            "time_start" => "date_format:H:i",
            "time_end" => "date_format:H:i|after:time_start",
            "day_id" => "required_if:type,class",
            "remind" => "required",
        ]);

        if (!empty($validated['date']) && !empty($validated['day_id'])) {
            return back()->withErrors(['type' => "Date and day cannot exist at the same time."]);
        }

        $schedule = Schedule::query()->create(array_merge($validated, ['user_id' => $user->id]));

        if ($schedule) {
            dd($schedule);
        }

        return 0;
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
