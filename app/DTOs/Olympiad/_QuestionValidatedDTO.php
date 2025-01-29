<?php

namespace App\DTOs\Olympiad;

use App\Models\Question;
use App\Rules\Image;
use App\Rules\UploadedFile;
use App\Services\QuestionService;
use Illuminate\Validation\Rule;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class _QuestionValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:questions,id',
            'olympiad_id' => 'required|integer|exists:olympiads,id',
            'title' => 'required|string|max:255',
            'question_type' => [
                'required',
                'integer',
                Rule::in(array_keys((new QuestionService())->getTypes()))
            ],
            'question_content_text' => [
                'nullable',
                Rule::requiredIf(request('type') === Question::TYPE_TEXT),
                'string',
                'max:745'
            ],
            'question_content_image' => [
                'nullable',
                Rule::requiredIf(request('type') === Question::TYPE_IMAGE),
                'file',
                new Image('jpg,jpeg,png,webp')
            ],
            'question_content_document' => [
                'nullable',
                Rule::requiredIf(request('type') === Question::TYPE_DOCUMENT),
                'file',
                'mimetypes:application/pdf',
                new UploadedFile()
            ],
            'correct_answer_cost' => 'required|integer|min:1',
            'wrong_answer_cost' => 'required|integer|max:-1',
            'variants' => 'required|array|size:4',
            'variants.*' => 'required|string|max:255',
            'correct_answer' => 'required|integer',
            'current_image' => 'nullable|string',
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
