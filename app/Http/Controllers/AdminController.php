<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\StoreStudentByAdminRequest;
use App\Http\Requests\UpdateStudentByAdminRequest;
use App\Models\Course;
use App\Models\Preference;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     *  Student Module
     *
     */

    public function studentIndex(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $students = User::query()
            ->where("role", "=", "student")
            ->leftJoin('students', 'users.id', '=', 'students.user_id')
            ->select('users.*', 'students.id as student_index', 'students.student_id',
                'students.gender', 'students.address', 'students.faculty', 'students.campus', 'students.program')
            ->search($request)
            ->latest('users.created_at')
            ->paginate(10);

        return Inertia::render("Admin/Student/Index", ["students" => $students]);
    }

    public function studentStore(StoreStudentByAdminRequest $request)
    {
        $data = $this->getStudentRequestData($request);

        $user = User::create($data['user']->toArray());

        if (!$user) {
            return back()->with(["status" => ["error" => "Something went wrong when creating the user."]]);
        }

        $student = Student::create(
            $data['student']->put("user_id", $user->id)->toArray()
        );

        if (!$student) {
            return back()->with(["status" => [
                "error" => "User has been created. But something went wrong when creating the student."
            ]]);
        }

        return back()->with(["status" => "Successfully added the new student!"]);
    }

    public function studentUpdate(UpdateStudentByAdminRequest $request, User $user)
    {
        $data = $this->getStudentRequestData($request);

        if (!$user->update($data['user']->toArray())) {
            return back()->with(["status" => ["error" => "Something went wrong when updating the user."]]);
        }

        $student = Student::updateOrCreate(["user_id" => $user->id], $data['student']->toArray());

        if (!$student) {
            return back()->with(["status" => [
                "error" => "User has been updated. But something went wrong when updating the student."
            ]]);
        }

        return back()->with(["status" => "Successfully updated the student information!"]);
    }

    public function getStudentRequestData(Request $request)
    {
        $data = [
            "user" => collect($request)
                ->except(['student_id', 'address', 'faculty', 'campus', 'program', 'gender'])
                ->filter(fn($request) => $request != null),

            "student" => collect($request)
                ->only(['student_id', 'address', 'faculty', 'campus', 'program', 'gender'])
                ->filter(fn($request) => $request != null),
        ];

        if ($data['user']->has('avatar')) {
            $path = $request->file('avatar')->store('images');
            if ($path) $data['user']->put('avatar', $path);
        }

        return $data;
    }

    public function studentDestroy(User $user)
    {
        if ($user->delete()) {
            return back()->with(["status" => "Successfully deleted the user."]);
        }

        return back()->with(["status" => ["error" => "Something went wrong when deleting the user"]]);
    }

    /**
     * Course Module
     *
     */

    public function courseIndex()
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

    public function courseStore(Request $request)
    {
        $validated = $request->validate([
            "student_id" => "required",
            "name" => "required",
            "code" => "required",
            "group" => "required"
        ]);

        $student = Student::where('student_id', '=', $validated['student_id'])->first();

        if (!$student) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "Student not found!"]]);
        }

        $course = collect($validated)->merge(["student_id" => $student->id])->toArray();

        if (Course::query()->create($course)) {
            return redirect()
                ->route("admin.course.index")
                ->with(["status" => "Successfully added the course to the student."]);
        }

        return back()->with(["status" => ["error" => "Something went wrong when creating the course for the student."]]);
    }

    public function courseUpdate(Request $request)
    {
        $validated = $request->validate([
            "id" => "required",
            "student_id" => "required",
            "name" => "required",
            "code" => "required",
            "group" => "required"
        ]);

        $student = Student::where('student_id', '=', $validated['student_id'])->first();

        if (!$student) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "Student with given ID not found!"]]);
        }

        $course = Course::find($validated['id']);

        if (!$course) {
            return redirect()
                ->route('admin.course.index',)
                ->with(["status" => ["warning" => "The selected course not found!"]]);
        }

        $validated = collect($validated)
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

    public function courseDestroy(Course $course)
    {
        if (!$course->delete()) {
            return back()->with(["status" => ["error" => "Something went wrong when deleting the course."]]);
        }

        return redirect()->route('admin.course.index')->with(['status' => "The course has been deleted."]);
    }


    /**
     * Course Module
     *
     */

    public function scheduleIndex(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $classes = Schedule::query()
            ->ofType("class")
            ->ofDay($request)
            ->search($request)
            ->leftJoin('users', 'users.id', '=', 'schedules.user_id')
            ->select('schedules.*', 'users.name', 'users.email')
            ->latest('created_at')
            ->paginate(15);

        /** @noinspection PhpUndefinedMethodInspection */
        $activities = Schedule::query()
            ->ofType("activity")
            ->ofMonth($request)
            ->search($request)
            ->leftJoin('users', 'users.id', '=', 'schedules.user_id')
            ->select('schedules.*', 'users.name', 'users.email')
            ->latest('created_at')
            ->paginate(15);

        return Inertia::render('Admin/Schedule/Index', [
            "classes" => $classes,
            'activities' => $activities
        ]);
    }

    public function scheduleCreate()
    {
        return Inertia::render('Admin/Schedule/Create');
    }

    public function scheduleStore(StoreScheduleRequest $request)

    {
        $validated = $request->validate([
            'email' => "required|email"
        ]);

        $user = User::where('email', '=', $validated['email'])->first();

        if (!$user) {
            return back()->with([
                'status' => ['error' => 'User with the given email address is not exist.']
            ]);
        }

        $userId = ['user_id' => $user->id];

        $schedule = $this->filterScheduleRequest($request);

        if (Schedule::query()->create($schedule->merge($userId)->toArray())) {
            return redirect()->route('admin.schedule.index')
                ->with(["status" => "A new schedule has been created!"]);
        }

        return back()->with([
            'status' => ['error' => 'Something went wrong when creating a new schedule.']
        ]);
    }

    public function scheduleEdit(Schedule $schedule)
    {
        return Inertia::render("Admin/Schedule/Edit", ["schedule" => $schedule]);
    }

    public function scheduleUpdate(StoreScheduleRequest $request, Schedule $schedule)
    {
        $data = $this->filterScheduleRequest($request)->all();

        if ($schedule->update($data)) {
            return redirect()->route('admin.schedule.index')->with(["status" => "The schedule has been updated!"]);
        }

        return back()->with(['status' => ['error' => 'Something went wrong when updating the schedule.']]);

        // TODO: Check if the schedule is today's upcoming event, then add this schedule to the events table too.
    }

    public function scheduleDestroy(Schedule $schedule)
    {
        if ($schedule->delete()) {
            return redirect()->route('admin.schedule.index')->with(['status' => "The schedule has been deleted."]);
        }
        return back()->with(["status" => ["error" => "Something went wrong when deleting the schedule."]]);
    }

    /**
     * Filter the required information based on the type.
     */
    public function filterScheduleRequest(StoreScheduleRequest $request): Collection
    {
        switch ($request['type']) {
            case 'class':
                return collect($request)->except('date');

            case 'activity':
                return collect($request)->except('day');
        }

        abort('422');
    }

    public function settingIndex()
    {
        $settings = Preference::query()
            ->leftJoin('telegrams', 'telegrams.id', '=', 'preferences.id')
            ->leftJoin('users', 'users.id', '=', 'preferences.user_id')
            ->select('preferences.*', 'telegrams.username', 'users.name', 'users.email')
            ->get();

        return Inertia::render('Admin/Setting/Index', ["settings" => $settings]);
    }

    public function settingStore(Request $request)
    {
        $validated = $request->validate([
            "email" => "email|required",
            "username" => "nullable",
            "time_before" => "nullable|numeric|min:10|max:60",
            "custom_message" => "nullable"
        ]);

        $user = User::where('email', '=', $validated['email'])->first();

        if (!$user) {
            return back()->with(["status" => [
                "error" => "User with the given email does not exist."
            ]]);
        }

        $preference = Preference::create([
            "user_id" => $user->id,
            "time_before" => $validated['time_before'],
            "custom_message" => $validated['custom_message']
        ]);

        if ($preference) {
            return back()->with(["status" => "Successfully created the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when creating the settings."
        ]]);
    }

    public function settingUpdate(Request $request, Preference $setting)
    {
        $validated = $request->validate([
            "username" => "nullable",
            "time_before" => "nullable|numeric|min:10|max:60",
            "custom_message" => "nullable"
        ]);

        $preference = $setting->update([
            "time_before" => $validated['time_before'],
            "custom_message" => $validated['custom_message']
        ]);

        if ($preference) {
            return back()->with(["status" => "Successfully updated the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when updating the settings."
        ]]);
    }

    public function settingDestroy(Preference $setting)
    {
        if ($setting->delete()) {
            return back()->with(["status" => "Successfully deleted the settings!"]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when deleting the settings."
        ]]);
    }
}
