<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentByAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|min:4|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string",
            "phone_number" => "nullable|string|max:12",
            "avatar" => "nullable|mimes:png,jpg,jpeg|max:3072",
            "student_id" => "nullable|string|min:10|max:10",
            "gender" => "nullable|in:male,female",
            "address" => "nullable|max:255",
            "faculty" => "nullable|max:255",
            "campus" => "nullable|max:255",
            "program" => "nullable|max:255",
        ];
    }
}
