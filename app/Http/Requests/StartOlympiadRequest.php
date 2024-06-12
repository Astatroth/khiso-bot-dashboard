<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartOlympiadRequest extends FormRequest
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
            'olympiad_id' => 'required|integer|exists:olympiads,id',
            'student_id' => 'required|integer|exists:students,id'
        ];
    }
}
