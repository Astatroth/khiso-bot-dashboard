<?php

namespace App\Services;

use App\DTOs\Olympiad\QuestionDTO;
use App\DTOs\Olympiad\QuestionPublicDTO;
use App\DTOs\Olympiad\QuestionValidatedDTO;
use App\Models\Olympiad;
use App\Models\Question;
use App\Traits\DynamicTableTrait;
use App\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

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
     * @param int               $olympiadId
     * @param int               $number
     * @param ValidatedDTO|null $result
     * @return QuestionPublicDTO|string
     */
    public function getQuestionByNumber(int $olympiadId, int $number, ValidatedDTO $result = null): QuestionPublicDTO|string
    {
        $olympiadService = new OlympiadService();
        $olympiad = $olympiadService->find($olympiadId);

        $questions = Question::with('answers')->where('olympiad_id', $olympiadId)->get();
        $answeredQuestions = !is_null($result->answers) ? array_keys($result->answers) : [];
        $question = $questions->filter(fn ($i) => !in_array($i->id, $answeredQuestions))->values()->first();

        if ($number > $questions->count() || is_null($question)) {
            $olympiadService->markFinished($result->id);
            return __("You have answered all the questions.")."\r\n\r\n".__("Your results will be considered.");
        }

        if ($result->created_at->raw->diffInMinutes(now()) >= $olympiad->time_limit) {
            $olympiadService->markFinished($result->id);

            $string = __("You have exceeded the time limit of :limit minutes", [
                'limit' => $olympiad->time_limit
            ]);

            if (!is_null($result->answers)) {
                $string .= "\r\n\r\n".__("Your results will be considered.");
            }

            return $string;
        }

        if (is_null($result->answers)) {
            $question = $questions->values()->first();

            return (new QuestionPublicDTO())->transform($question);
        }

        return (new QuestionPublicDTO())->transform($question);
    }

    public function getRawTypes(): array
    {
        return [
            Question::TYPE_TEXT => 'Text',
            Question::TYPE_IMAGE => 'Image',
            Question::TYPE_DOCUMENT => 'Document',
        ];
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
     * @param int $questionId
     * @param int $answerId
     * @param int $studentId
     * @return bool|string
     */
    public function registerAnswer(int $questionId, int $answerId, int $studentId): bool|string
    {
        $olympiadService = new OlympiadService();
        $question = $this->find($questionId);

        // Check if time limit is not exceeded yet
        $result = $question->olympiad->results()->where('student_id', $studentId)->first();
        if ($result->created_at->diffInMinutes(now()) >= $question->olympiad->time_limit) {
            $olympiadService->markFinished($result->id);

            $string = __("You have exceeded the time limit of :limit minutes", [
                'limit' => $question->olympiad->time_limit
            ]);

            if (!is_null($result->answers)) {
                $string .= "\r\n\r\n".__("Your results will be considered.");
            }

            return $string;
        }

        if (is_null($result->answers)) {
            $result->update([
                'answers' => [$questionId => $answerId]
            ]);
        } else {
            $answers = $result->answers;
            $answers[$questionId] = $answerId;
            $result->update([
                'answers' => $answers
            ]);
        }

        return true;
    }

    /**
     * @param int   $olympiadId
     * @param int   $studentId
     * @param array $answers
     * @return bool|string
     */
    public function registerAnswers(int $olympiadId, int $studentId, array $answers): string
    {
        $olympiadService = new OlympiadService();
        $olympiad = $olympiadService->find($olympiadId);

        if ($olympiad->status === Olympiad::STATUS_ENDED) {
            return __('The olympiad has ended.');
        }

        $question = $olympiad->question;
        $result = $question->olympiad->results()->where('student_id', $studentId)->first();
        $olympiadService->markFinished($result->id);

        if ($result->created_at->diffInMinutes(now()) >= $question->olympiad->time_limit) {
            $string = __("You have exceeded the time limit of :limit minutes", [
                'limit' => $question->olympiad->time_limit
            ]);

            if (!is_null($result->answers)) {
                $string .= "\r\n\r\n" . __("Your results will be considered.");
            }

            return $string;
        }

        $result->update(['answers' => $answers]);

        return __("You have answered all the questions.")."\r\n\r\n".__("Your results will be considered.");
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
                'title' => 'Question',
                'olympiad_id' => $dto->olympiad_id,
                'type' => $dto->question_type,
                'correct_answer_cost' => $dto->correct_answer_cost,
                'wrong_answer_cost' => $dto->wrong_answer_cost,
            ];

            $file = !is_null($dto->question_content_document)
                ? $this->uploadFile($dto->question_content_document)
                : $dto->current_file;

            $data['content'] = $file;

            $question = Question::updateOrCreate(['id' => $dto->id], $data);

            foreach ($dto->variants as $id => $variant) {
                $question->answers()->updateOrCreate(['question_number' => $id], [
                    'answer' => $variant
                ]);
            }
        });
    }
}
