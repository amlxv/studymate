<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Campus;
use App\Models\Faculty;
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
        $campuses = Campus::all()->toArray();
        $faculties = Faculty::all()->toArray();

        return Inertia::render("Profile/Index", [
            "user" => $user,
            "student" => $student,
            "admin" => $admin,
            "campuses" => $campuses,
            "faculties" => $faculties,
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
        $user = User::query()->find($id);

        if (!$user || $user->id !== Auth::id()) {
            return back()->with(["status" => [
                "warning" => "You're not authorized to make changes to this profile!"
            ]]);
        }

        if ($request->has("intro")) {
            $user->update(["intro" => $request->get("intro")]);
        }

        $userData = collect($request)
            ->only("avatar", "name", "phone_number")
            ->filter(fn($request) => $request != null);

        $studentData = collect($request)
            ->except("avatar", "name", "phone_number")
            ->filter(fn($request) => $request != null)
            ->map(fn($data) => is_array($data) ? $data['id'] : $data)
            ->toArray();

        if ($user->student && $user->student->student_id) {
            $studentData = collect($studentData)
                ->except("student_id")
                ->toArray();
        }

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
        }

        // Prevent from returning message
        if ($request->has("intro")) {
            return back();
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
