<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $user = User::query()->where("id", $userId)->first();
        $student = Student::query()->where("user_id", $userId)->first();
        $admin = Admin::query()->where("user_id", $userId)->first();

        return Inertia::render("Profile/Index", [
            "user" => $user,
            "student" => $student,
            "admin" => $admin
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
    public function update(Request $request, User $profile)
    {
        $validated = $request->validate([
            "avatar" => "nullable|mimes:png,jpg,jpeg|max:3072",
            "name" => "required|min:4|max:255",
            "phone_number" => "nullable|starts_with:+60",
            "gender" => "nullable|in:male,female",
            "student_id" => "nullable|min:10|max:10",
            "address" => "nullable|max:255",
            // "institute" => "required|max:255",
            "campus" => "nullable|max:255",
            "faculty" => "nullable|max:255",
            "program" => "nullable|max:255",
        ]);

        $user = $profile;

        if ($user->id !== Auth::id()) {
            return back()->with(["status" => [
                "warning" => "You're not authorized to make changes to this profile!"
            ]]);
        }

        $userData = collect($validated)
            ->only("avatar", "name", "phone_number")
            ->filter(fn($request) => $request != null);

        $studentData = collect($validated)
            ->except("avatar", "name", "phone_number")
            ->filter(fn($request) => $request != null)
            ->toArray();


        if ($userData->has('avatar')) {
            $path = $request->file('avatar')->store('images');
            if ($path) $userData->put('avatar', $path);
        }

        if (!$user->update($userData->toArray())) {
            return back()->with(["status" => [
                "failed" => "Operation stopped. Something went wrong when updating user information."
            ]]);
        }

        if ($user->isStudent()) {
            $student = Student::updateOrCreate(["user_id" => $user->id], $studentData);

            if (!$student) {
                return back()->with(["status" => [
                    "failed" => "Operation stopped. Something went wrong when updating student information."
                ]]);
            }

            // TODO: If student id exist, then fetch the student information
        }

        return back()->with(["status" => [
            "successful" => "Your profile has been updated!"
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
