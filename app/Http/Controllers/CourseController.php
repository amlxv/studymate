<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Telegram;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Traits\ScheduleScraperTrait;

class CourseController extends Controller
{
    use ScheduleScraperTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $courses = $student ? $student->courses : [];

        return Inertia::render('Student/Course/Index', ["courses" => $courses]);
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
     * @throws \Exception
     */
    public function store(StoreCourseRequest $request)
    {
        $telegram = Telegram::query()->where("user_id", "=", Auth::id())->count();

        if ($request['remind'] && !$telegram) {
            return back()->with(["status" => [
                "error" => "Telegram integration required to perform this action.
                Please link your Telegram account in your account settings to continue."
            ]]);
        }

        return $this->handleScheduleRequest($request, Auth::id(), function ($user, $timetables, $course) use ($request) {
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
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $telegram = Telegram::query()->where("user_id", "=", Auth::id())->count();

        if ($request['remind'] && !$telegram) {
            return back()->with(["status" => [
                "error" => "Telegram integration required to perform this action.
                Please link your Telegram account in your account settings to continue."
            ]]);
        }

        return $this->handleScheduleRequest($request, Auth::id(), function ($user, $timetables) use ($course, $request) {

            if ($course->update($request->toArray())) {
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

        return redirect()->route('course.index')->with(['status' => "The course has been deleted."]);
    }
}
