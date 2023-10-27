<?php

namespace App\Http\Requests\Checkins;

use Illuminate\Foundation\Http\FormRequest;

class CreateCheckinRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'schedule_id' => 'required|exists:schedules,id',
            'checkin_date' => 'required',
            'hour' => 'required',
        ];
    }
}
