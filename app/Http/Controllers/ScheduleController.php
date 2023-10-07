<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Student/Schedule/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "type" => "in:class,activity",
            "title" => "required",
            "description" => "required",
            "day" => "required_if:type,class",
            "date" => "required_if:type,activity",
            "time_start" => "date_format:H:i",
            "time_end" => "date_format:H:i|after:time_start",
            "remind" => "required",
        ]);

        switch ($validated['type']) {
            case 'class':
                $validated = collect($validated)->except('date');
                break;

            case 'activity':
                $validated = collect($validated)->except('day');
                break;
        }

        $additionalData = ['user_id' => $request->user()->id];

        if (Schedule::query()->create($validated->merge($additionalData)->toArray())) {
            return redirect()->route('schedule.index')->with(["status" => "A new schedule has been created!"]);
        }

        return back()->with(['status' => ['error' => 'Something went wrong when creating a new schedule.']]);
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
