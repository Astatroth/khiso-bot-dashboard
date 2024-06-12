<?php

namespace App\Services;

use App\DTOs\Olympiad\QuestionDTO;
use App\DTOs\Olympiad\QuestionValidatedDTO;
use App\Models\Question;
use App\Traits\DynamicTableTrait;
use App\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    use DynamicTableTrait;
    use MediaTrait;

    /**
     * @var string
     */
    protected $model = Question::class;

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        $query->where('olympiad_id', (int)$filters['olympiadId']);
    }

    /**
     * @param Builder $query
     * @param string  $search
     * @return void
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->where('title', 'like', "%{$search}%");
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Question::where('id', $id)->delete();
    }

    /**
     * @param int|null $id
     * @return Question|null
     */
    public function find(?int $id): ?Question
    {
        return Question::with('answers')->find($id);
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return [
            Question::TYPE_TEXT => __('Text'),
            Question::TYPE_IMAGE => __('Image'),
            Question::TYPE_DOCUMENT => __('Document'),
        ];
    }

    /**
     * @param Builder $query
     * @return void
     */
    protected function includeRelations(Builder &$query)
    {
        $query->with('answers');
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new QuestionDTO())->transform($i));
    }

    /**
     * @param QuestionValidatedDTO $dto
     * @return void
     * @throws \Throwable
     */
    public function save(QuestionValidatedDTO $dto): void
    {
        \DB::transaction(function () use ($dto) {
            $data = [
                'olympiad_id' => $dto->olympiad_id,
                'type' => $dto->question_type,
                'title' => $dto->title,
                'correct_answer_cost' => $dto->correct_answer_cost,
                'wrong_answer_cost' => $dto->wrong_answer_cost
            ];

            if ((int)$dto->question_type === Question::TYPE_TEXT) {
                $data['content'] = strip_tags($dto->question_content_text, ['a', 'b', 'u', 'i']);
            } elseif ((int)$dto->question_type === Question::TYPE_IMAGE) {
                $image = !is_null($dto->question_content_image)
                    ? $this->uploadImage($dto->question_content_image, encodeTo: 'webp')
                    : $dto->current_image;

                $data['content'] = $image;
            } else {
                $file = !is_null($dto->question_content_document)
                    ? $this->uploadFile($dto->question_content_document)
                    : $dto->current_file;

                $data['content'] = $file;
            }

            $question = Question::updateOrCreate(['id' => $dto->id], $data);

            foreach ($dto->variants as $id => $variant) {
                $question->answers()->updateOrCreate(['id' => $id], [
                    'answer' => $variant,
                    'is_correct' => $id === (int)$dto->correct_answer
                ]);
            }
        });
    }
}
