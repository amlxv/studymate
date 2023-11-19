<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use LaravelIdea\Helper\App\Models\_IH_Course_QB;

class CourseController extends Controller
{
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
     */
    public function store(StoreCourseRequest $request)
    {
        return $this->handleScheduleRequest($request, function ($timetables, $course) use ($request) {
            $course = Course::query()->create($course);

            if ($course) {
                return $this->handleCreateSchedule($timetables, $request, Auth::user(), $course);
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
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        return $this->handleScheduleRequest($request, function ($timetables) use ($course, $request) {

            if ($course->update($request->toArray())) {
                $schedules = Schedule::query()->where("course_id", "=", $course->id);
                $schedules->delete();
                $schedules = $schedules->get();

                if (count($schedules)) {
                    return back()->with(["status" => [
                        "error" => "Something went wrong when removing the old schedule."
                    ]]);
                }

                return $this->handleCreateSchedule($timetables, $request, Auth::user(), $course);
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


    /**
     * @param StoreCourseRequest $request
     * @param $callback
     * @return RedirectResponse
     */
    public function handleScheduleRequest(StoreCourseRequest $request, $callback)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student || !$student->isProfileCompleted()) {
            return redirect()->route('profile.index')
                ->with(["status" => ["warning" => "Some of your student information is missing. Please complete them to continue."]]);
        }

        $campus = Campus::query()->find($student->campus);
        $campusCode = $campus ? $campus['code'] : '';

        $faculty = Faculty::query()->find($student->faculty);
        $facultyCode = $faculty ? $faculty['code'] : '';

        $timetableInstance = new UiTMController($student->student_id, $request['code'], $request['group'], $campusCode, $facultyCode);
        $timetables = $timetableInstance->getTimetables();

        if (!$timetables) {
            return back()->with(["status" => ["warning" => "There is no timetable matched with your details."]]);
        }

        $course = collect($request)->merge(["student_id" => $student->id])->toArray();

        return $callback($timetables, $course);
    }

    /**
     * @param array $timetables
     * @param StoreCourseRequest $request
     * @param Builder|User|null $user
     * @param Model|_IH_Course_QB|Builder|Course $course
     * @return RedirectResponse
     */
    public function handleCreateSchedule(array $timetables, StoreCourseRequest $request, Builder|User|null $user, Model|_IH_Course_QB|Builder|Course $course): RedirectResponse
    {
        $schedules = collect($timetables)->each(function ($timetable) use ($request, $user, $course) {

            $title = $request['name'];
            $day = $timetable['day'];
            $time_start = $timetable['time_start'];
            $time_end = $timetable['time_end'];
            $description = $request['code'] .
                " - " . $request['name'] . "\n\n" .
                "Venue: " . (collect($timetable)->has('venue') ? $timetable['venue'] : '') . "\n" .
                "Start: " . $timetable['time_start'] . "\n" .
                "End: " . $timetable['time_end'] . "\n\n" .
                "Lecturer: " . (collect($timetable)->has('lecturer') ? $timetable['lecturer'] : '');

            $schedule = Schedule::query()->create([
                "course_id" => $course->id,
                "user_id" => $user->id,
                "title" => $title,
                "description" => $description,
                "day" => $day,
                "time_start" => $time_start,
                "time_end" => $time_end,
                "type" => "class",
                "remind" => true,
            ]);

            if (!$schedule) {
                return back()->with(["status" => [
                    "error" => "Something went wrong when adding the schedule."
                ]]);
            }

            return true;
        });

        if ($schedules) {
            return redirect()->route("course.index")
                ->with(["status" => "Successfully added the schedule for this course."]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when adding the schedule for this course."
        ]]);
    }
}
