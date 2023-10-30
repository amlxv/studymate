<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::query()->where("id", "=", Auth::id())->first();
        $student = $user->student;
        $courses = $student ? $student->courses : [];

        return Inertia::render('Student/Course/Index', ["courses" => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Student/Course/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "code" => "required",
            "group" => "required"
        ]);

        $user = User::query()->where("id", "=", Auth::id())->first();
        $student = $user->student;

        if (!$student || !$student->student_id) {
            return redirect()->route('profile.index',)
                ->with(["status" => ["warning" => "Complete your student information to continue!"]]);
        }

        $course = collect($validated)->merge(["student_id" => $student->id])->toArray();

        if (Course::query()->create($course)) {
            return redirect()->route("course.index")
                ->with(["status" => "Successfully added the course."]);
        }

        return back()->with(["status" => ["error" => "Something went wrong when creating the course."]]);
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
    public function edit(Course $course)
    {
        if ($course->student->user->id != Auth::id()) {
            return redirect()->route("course.index")
                ->with(["status" => ["error" => "This course does not belongs to you!"]]);
        }

        return Inertia::render("Student/Course/Edit", ["course" => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            "name" => "required",
            "code" => "required",
            "group" => "required"
        ]);

        if ($course->student->user->id != Auth::id()) {
            return redirect()->route("course.index")
                ->with(["status" => ["error" => "This course does not belongs to you!"]]);
        }

        if ($course->update($validated)) {
            return redirect()->route("course.index")
                ->with(["status" => "Successfully updated the course."]);
        }

        return back()->with(["status" => ["error" => "Something went wrong when updating the course."]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if (!$course->delete()) {
            return back()->with(["status" => ["error" => "Something went wrong when deleting the course."]]);
        }

        return redirect()->route('course.index')->with(['status' => "The course has been deleted."]);
    }
}
