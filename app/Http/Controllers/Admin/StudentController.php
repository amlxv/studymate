<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreStudentRequestByAdmin;
use App\Http\Requests\UpdateStudentRequestByAdmin;
use App\Models\Campus;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

        $campuses = Campus::all()->toArray();
        $faculties = Faculty::all()->toArray();

        return Inertia::render("Admin/Student/Index", [
            "students" => $students,
            "campuses" => $campuses,
            "faculties" => $faculties
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
    public function store(StoreStudentRequestByAdmin $request)
    {
        $data = $this->getStudentRequestData($request);
        $user = User::create($data['user']->toArray());

        if (!$user) {
            return back()->with(["status" => [
                "error" => "Something went wrong when creating the user."
            ]]);
        }

        $student = Student::create(
            $data['student']->put("user_id", $user->id)->toArray()
        );

        if ($student) {
            return back()->with([
                "status" => "Successfully added the new student!"
            ]);
        }

        return back()->with(["status" => [
            "error" => "User has been created. xxxBut something went wrong when creating the student."
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
    public function update(UpdateStudentRequestByAdmin $request, string $id)
    {
        $data = $this->getStudentRequestData($request);
        $user = User::find($id);

        if (!$user || !$user->update($data['user']->toArray())) {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user && $user->delete()) {
            return back()->with([
                "status" => "Successfully deleted the user."
            ]);
        }

        return back()->with(["status" => [
            "error" => "Something went wrong when deleting the user"
        ]]);
    }

    public function getStudentRequestData(Request $request)
    {
        $data = [
            "user" => collect($request)
                ->except(['student_id', 'address', 'faculty', 'campus', 'program', 'gender'])
                ->filter(fn($request) => $request != null),

            "student" => collect($request)
                ->only(['student_id', 'address', 'faculty', 'campus', 'program', 'gender'])
                ->filter(fn($request) => $request != null)
                ->map(fn($data) => is_array($data) ? $data['id'] : $data),
        ];

        if ($data['user']->has('avatar')) {
            $path = $request->file('avatar')->store('images');
            if ($path) $data['user']->put('avatar', $path);
        }

        return $data;
    }
}
