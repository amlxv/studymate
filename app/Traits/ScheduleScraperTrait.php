<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UiTMController;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\StoreCourseRequestByAdmin;
use App\Http\Requests\UpdateCourseRequestByAdmin;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use LaravelIdea\Helper\App\Models\_IH_Course_QB;

trait ScheduleScraperTrait
{
    /**
     * @param StoreCourseRequest|StoreCourseRequestByAdmin|UpdateCourseRequestByAdmin $request
     * @param $userId
     * @param $callback
     * @return RedirectResponse
     */
    public function handleScheduleRequest(StoreCourseRequest|StoreCourseRequestByAdmin|UpdateCourseRequestByAdmin $request, $userId, $callback): RedirectResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return back()->with(["status" => [
                "warning" => "User not found. Please try again later."
            ]]);
        }

        $student = $user->student;

        if (!$student || !$student->isProfileCompleted()) {
            return Auth::user()->isAdmin() ?
                redirect()
                    ->back()
                    ->with(["status" => [
                        "warning" => "The student information is missing. Please complete them to continue."
                    ]])
                :
                redirect()
                    ->route("profile.index", ["error" => "missing-student-information"])
                    ->with(["status" => [
                        "warning" => "The student information is missing. Please complete them to continue."
                    ]]);
        }

        $campus = Campus::query()->find($student->campus);
        $campusCode = $campus ? $campus['code'] : '';

        $faculty = Faculty::query()->find($student->faculty);
        $facultyCode = $faculty ? $faculty['code'] : '';

        $timetableInstance = new UiTMController($student->student_id, $request['code'], $request['group'], $campusCode, $facultyCode);
        $timetables = $timetableInstance->getTimetables();

        if (!$timetables) {
            return back()->with(["status" => ["warning" => "There are no timetables matching the given details."]]);
        }

        $course = collect($request)->merge(["student_id" => $student->id])->toArray();

        return $callback($user, $timetables, $course);
    }

    /**
     * @param array $timetables
     * @param StoreCourseRequest|StoreCourseRequestByAdmin|UpdateCourseRequestByAdmin $request
     * @param Builder|User|null $user
     * @param Model|_IH_Course_QB|Builder|Course $course
     * @return RedirectResponse
     * @throws \Exception
     */
    public function handleCreateSchedule(array $timetables, StoreCourseRequest|StoreCourseRequestByAdmin|UpdateCourseRequestByAdmin $request, Builder|User|null $user, Model|_IH_Course_QB|Builder|Course $course): RedirectResponse
    {
        try {
            $schedules = collect($timetables)->each(function ($timetable) use ($request, $user, $course) {
                $title = $request['name'];
                $day = $timetable['day'];
                $time_start = $timetable['time_start'];
                $time_end = $timetable['time_end'];
                $description = $this->createDescription(
                    $request['code'], $request['name'], $timetable['venue'],
                    $timetable['time_start'], $timetable['time_end'], $timetable['lecturer']);

                $data = [
                    "course_id" => $course->id,
                    "user_id" => $user->id,
                    "title" => $title,
                    "description" => $description,
                    "day" => $day,
                    "time_start" => $time_start,
                    "time_end" => $time_end,
                    "type" => "class",
                    "remind" => (bool)$request['remind'],
                ];

                if (!Schedule::query()->create($data)) {
                    throw new \Exception("Something went wrong when adding the schedule.");
                }

                return true;
            });
        } catch (\Exception $error) {
            return back()->with(["status" => ["error" => $error->getMessage()]]);
        }

        if ($schedules) {
            return back()->with(["status" => "Successfully added the schedule for this course."]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when adding the schedule for this course."
        ]]);
    }

    /**
     * Generate the description for schedule
     * added by creating the course.
     *
     * @param $courseCode
     * @param $courseName
     * @param $venue
     * @param $timeStart
     * @param $timeEnd
     * @param $lecturer
     * @return string
     */
    public function createDescription($courseCode = null, $courseName = null, $venue = null, $timeStart = null, $timeEnd = null, $lecturer = null): string
    {
        return $courseCode .
            " - " . $courseName . "\n\n" .
            "Venue: " . ($venue ?? '-') . "\n" .
            "Start: " . $timeStart . "\n" .
            "End: " . ($timeEnd ?? '-') . "\n\n" .
            "Lecturer: " . ($lecturer ?? '-');
    }
}


