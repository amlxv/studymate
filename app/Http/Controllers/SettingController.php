<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\Telegram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = User::query()->where("id", "=", $user_id)->first();
        $telegram = $user->telegram ? $user->telegram->first()->toArray() : [];
        $preferences = $user->preference ? $user->preference->first()->toArray() : [];

        return Inertia::render('Student/Setting/Index', [
            "settings" => array_merge($telegram, $preferences)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        if (Auth::id() != $id) {
            return back()->with(["status" => [
                "warning" => "You're not authorized to make this request!"
            ]]);
        }

        $validated = $request->validate([
            "username" => "required",
            "time_before" => "nullable|numeric|min:10|max:60",
            "custom_message" => "nullable"
        ]);

        $telegram = Telegram::updateOrCreate([
            "user_id" => $id,
        ], [
            "user_id" => $id,
            "username" => $validated['username'],
        ]);

        if (!$telegram) {
            return back()->with(["status" => [
                "error" => "Something went wrong when updating the Telegram information."
            ]]);
        }

        $preference = Preference::updateOrCreate(["user_id" => $id], [
            "user_id" => $id,
            "telegram_id" => $telegram->id,
            "time_before" => $validated['time_before'],
            "custom_message" => $validated['custom_message']
        ]);

        if ($preference) {
            return back()->with(["status" => "Successfully updated the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when updating the settings"
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
