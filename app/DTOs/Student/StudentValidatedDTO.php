<?php

namespace App\DTOs\Student;

use Propaganistas\LaravelPhone\Rules\Phone;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class StudentValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'chat_id' => 'required|integer',
            'phone_number' => [
                'required',
                (new Phone())->international()->mobile()->country('UZ')
            ],
            'full_name' => 'required|string',
            'gender' => 'required|integer|min:1|max:2',
            'date_of_birth' => 'required|date_format:d.m.Y',
            'language' => 'required|string|in:ru,uz',
            'is_verified' => 'required|integer',
            'is_subscribed' => 'required|integer',
            'region_id' => 'required|integer|exists:regions,id',
            'district_id' => 'required|integer|exists:districts,id',
            'institution_id' => 'required|integer|exists:institutions,id',
            'grade' => 'required|integer|min:1|max:11'
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
