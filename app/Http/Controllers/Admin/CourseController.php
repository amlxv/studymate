<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCourseRequestByAdmin;
use App\Http\Requests\UpdateCourseRequestByAdmin;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::all()->map(function ($course) {
            return array_merge(
                $course->toArray(),
                ['student' => $course->student->toArray()],
                ['user' => $course->student->user->toArray()]
            );
        });

        return Inertia::render('Admin/Course/Index', ["courses" => $courses]);
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
    public function store(StoreCourseRequestByAdmin $request)
    {
        $student = Student::where('student_id', '=', $request['student_id'])->first();

        if (!$student) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "Student not found!"]]);
        }

        $course = collect($request)->merge(["student_id" => $student->id])->toArray();

        if (Course::query()->create($course)) {
            return redirect()
                ->route("admin.course.index")
                ->with(["status" => "Successfully added the course to the student."]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when creating the course for the student."
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
    public function update(UpdateCourseRequestByAdmin $request)
    {
        $student = Student::where('student_id', '=', $request['student_id'])->first();

        if (!$student) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "Student with given ID not found!"]]);
        }

        $course = Course::find($request['id']);

        if (!$course) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "The selected course not found!"]]);
        }

        $validated = collect($request)
            ->except('student_id')
            ->merge(["student_id" => $student->id])
            ->toArray();

        if ($course->update($validated)) {
            return redirect()
                ->route("admin.course.index")
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
            return back()->with(["status" => [
                "error" => "Something went wrong when deleting the course."
            ]]);
        }

        return redirect()->route('admin.course.index')
            ->with(['status' => "The course has been deleted."]);
    }
}
