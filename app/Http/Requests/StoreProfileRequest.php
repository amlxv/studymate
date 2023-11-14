<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "avatar" => "nullable|mimes:png,jpg,jpeg|max:3072",
            "name" => "required|min:4|max:255",
            "phone_number" => "nullable|string|starts_with:60",
            "gender" => "nullable|in:male,female",
            "student_id" => "nullable|min:10|max:10",
            "address" => "nullable|max:255",
            // "institute" => "required|max:255",
            "campus" => "nullable|max:255",
            "faculty" => "nullable|max:255",
            "program" => "nullable|max:255",
        ];
    }
}
