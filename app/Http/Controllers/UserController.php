<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
            ]);
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
}
