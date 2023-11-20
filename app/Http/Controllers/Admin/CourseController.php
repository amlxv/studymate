<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCourseRequestByAdmin;
use App\Http\Requests\UpdateCourseRequestByAdmin;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\ScheduleScraper;

class CourseController extends AdminController
{

    use ScheduleScraper;

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

        $userId = $student->user->id;

        return $this->handleScheduleRequest($request, $userId, function ($user, $timetables, $course) use ($request) {
            $course = Course::query()->create($course);

            if ($course) {
                return $this->handleCreateSchedule($timetables, $request, $user, $course);
            }

            return back()->with(["status" => ["error" => "Something went wrong when creating the course."]]);
        });
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

        $userId = $student->user->id;
        $course = Course::find($request['id']);

        if (!$course) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "The selected course not found!"]]);
        }

        return $this->handleScheduleRequest($request, $userId, function ($user, $timetables) use ($course, $request, $student) {

            $data = collect($request)->merge(["student_id" => $student->id])->toArray();

            if ($course->update($data)) {
                $schedules = Schedule::query()->where("course_id", "=", $course->id);
                $schedules->delete();
                $schedules = $schedules->get();

                if (count($schedules)) {
                    return back()->with(["status" => [
                        "error" => "Something went wrong when removing the old schedule."
                    ]]);
                }

                return $this->handleCreateSchedule($timetables, $request, $user, $course);
            }

            return back()->with(["status" => ["error" => "Something went wrong when updating the course."]]);
        });
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
