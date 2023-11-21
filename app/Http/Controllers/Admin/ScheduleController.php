<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreScheduleRequestByAdmin;
use App\Http\Requests\UpdateScheduleRequestByAdmin;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use App\Traits\ScheduleTrait;
use App\Traits\EventTrait;

class ScheduleController extends AdminController
{
    use ScheduleTrait, EventTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $classes = Schedule::query()
            ->ofType("class")
            ->ofDay($request)
            ->search($request)
            ->leftJoin('users', 'users.id', '=', 'schedules.user_id')
            ->select('schedules.*', 'users.name', 'users.email')
            ->latest('created_at')
            ->paginate(15);

        /** @noinspection PhpUndefinedMethodInspection */
        $activities = Schedule::query()
            ->ofType("activity")
            ->ofMonth($request)
            ->search($request)
            ->leftJoin('users', 'users.id', '=', 'schedules.user_id')
            ->select('schedules.*', 'users.name', 'users.email')
            ->latest('created_at')
            ->paginate(15);

        return Inertia::render('Admin/Schedule/Index', [
            "classes" => $classes,
            'activities' => $activities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Schedule/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequestByAdmin $request)
    {
        $user = User::where("email", "=", $request["email"])->first();

        if (!$user) {
            return back()->with(["status" => [
                "error" => "The user with given email address does not exist."
            ]]);
        }

        $userId = ["user_id" => $user->id];
        $schedule = $this->filterScheduleRequest($request);
        $schedule = $schedule->merge($userId)->toArray();

        try {
            $schedule = Schedule::query()->create($schedule);

            if ($schedule) {
                return redirect()->route('admin.schedule.index')
                    ->with(["status" => "The schedule has been successfully created."]);
            }
        } catch (\Exception $error) {
            return back()->with(['status' => ['error' => $error->getMessage()]]);
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
    public function edit(Schedule $schedule)
    {
        return Inertia::render("Admin/Schedule/Edit", ["schedule" => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequestByAdmin $request, Schedule $schedule)
    {
        $data = $this->filterScheduleRequest($request)->all();

        try {
            if ($schedule->update($data)) {
                return redirect()->route("admin.schedule.index")
                    ->with(["status" => "The schedule has been successfully updated!"]);

            }
        } catch (\Exception $error) {
            return back()->with(["status" => ["error" => $error->getMessage()]]);
        }

        return back()->with(["status" => ["error" => "Something went wrong when updating the schedule."]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->delete()) {
            return redirect()->route('admin.schedule.index')
                ->with(['status' => "The schedule has been deleted."]);
        }
        return back()->with(["status" => [
            "error" => "Something went wrong when deleting the schedule."
        ]]);
    }

    /**
     * Filter the required information based on the type.
     */
    public function filterScheduleRequest(StoreScheduleRequestByAdmin|UpdateScheduleRequestByAdmin $request): Collection
    {
        switch ($request['type']) {
            case 'class':
                return collect($request)->except('date');

            case 'activity':
                return collect($request)->except('day');
        }

        abort('422');
    }
}
