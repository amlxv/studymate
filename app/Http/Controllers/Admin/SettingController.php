<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreSettingRequestByAdmin;
use App\Http\Requests\UpdateSettingRequestByAdmin;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Preference::query()
            ->leftJoin('telegrams', 'telegrams.id', '=', 'preferences.id')
            ->leftJoin('users', 'users.id', '=', 'preferences.user_id')
            ->select('preferences.*', 'telegrams.username', 'users.name', 'users.email')
            ->get();

        return Inertia::render('Admin/Setting/Index', ["settings" => $settings]);
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
    public function store(StoreSettingRequestByAdmin $request)
    {
        $user = User::where('email', '=', $request['email'])->first();

        if (!$user) {
            return back()->with(["status" => [
                "error" => "User with the given email does not exist."
            ]]);
        }

        $preference = Preference::create([
            "user_id" => $user->id,
            "time_before" => $request['time_before'],
            "custom_message" => $request['custom_message']
        ]);

        if ($preference) {
            return back()->with(["status" => "Successfully created the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when creating the settings."
        ]]);
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
    public function update(UpdateSettingRequestByAdmin $request, string $id)
    {
        $setting = Preference::query()->find($id);

        if (!$setting) {
            return back()->with(["status" => [
                "error" => "Something went wrong when updating the settings."
            ]]);
        }

        $preference = $setting->update([
            "time_before" => $request['time_before'],
            "custom_message" => $request['custom_message']
        ]);

        if ($preference) {
            return back()->with(["status" => "Successfully updated the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when updating the settings."
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $setting = Preference::query()->find($id);

        if ($setting && $setting->delete()) {
            return back()->with(["status" => "Successfully deleted the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when deleting the settings."
        ]]);
    }
}
