<?php

namespace App\DTOs\Olympiad;

use App\Models\Question;
use App\Rules\Image;
use App\Rules\UploadedFile;
use App\Services\QuestionService;
use Illuminate\Validation\Rule;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuestionValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:questions,id',
            'olympiad_id' => 'required|integer|exists:olympiads,id',
            'question_type' => [
                'required',
                'integer',
                Rule::in(array_keys((new QuestionService())->getTypes()))
            ],
            'question_content_document' => [
                'required_without:current_file',
                'file',
                'mimetypes:application/pdf',
                new UploadedFile()
            ],
            'correct_answer_cost' => 'required|integer|min:1',
            'wrong_answer_cost' => 'required|integer|max:-1',
            'variants' => 'required|array|min:1',
            'current_file' => 'nullable|string'
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
