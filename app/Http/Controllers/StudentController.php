<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'id' => 'required',
            'campus' => 'required',
            'faculty' => 'required',
            'program' => 'required',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable'
        ]);

        $user = Auth::user();

        $student = Student::create(array_merge($validated, ['user_id' => $user->id]));

        if ($student) {
            return redirect()->back()->with('status', 'A new student data has been created');
        }

        return redirect()->back()->with('status', ['error' => 'Something went wrong went creating a student']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
