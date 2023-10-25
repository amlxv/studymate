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

            /** @noinspection PhpUndefinedMethodInspection */
            $upcomingEvents = Schedule::query()
                ->today($user->id)
                ->get();

            $upcomingEvents = collect($upcomingEvents)
                ->filter(fn($item) => $item['time_start'] >= now()->format("H:i"));

            return Inertia::render('Student/Home/Index', [
                "schedules" => $schedules,
                "upcomingEvents" => $upcomingEvents
            ]);
        }

        abort(404);
    }
}
