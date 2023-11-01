<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentByAdminRequest;
use App\Http\Requests\UpdateStudentByAdminRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

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

}
