<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequestByAdmin extends FormRequest
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
            "type" => "in:class,activity",
            "title" => "required",
            "description" => "required",
            "day" => "required_if:type,class",
            "date" => "required_if:type,activity",
            "time_start" => "required",
            "time_end" => "nullable|after:time_start",
            "remind" => "required",
        ];
    }
}
