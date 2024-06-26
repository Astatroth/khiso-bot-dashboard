<?php

namespace App\Services;

use App\DTOs\Olympiad\OlympiadDTO;
use App\DTOs\Olympiad\OlympiadResultDTO;
use App\DTOs\Olympiad\OlympiadValidatedDTO;
use App\Events\OlympiadEndedEvent;
use App\Events\OlympiadStartedEvent;
use App\Models\Olympiad;
use App\Models\OlympiadResult;
use App\Models\Student;
use App\Traits\DynamicTableTrait;
use App\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class OlympiadService
{
    use DynamicTableTrait;
    use MediaTrait;

    /**
     * @var string
     */
    protected $model = Olympiad::class;

    /**
     * @var string|null
     */
    protected $failReason = null;

    /**
     * @var string|null
     */
    protected $signUpFailReason = null;

    /**
     * @var string|null
     */
    protected $startFailReason = null;

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        if (isset($filters['status']) && $filters['status'] !== 'any') {
            $query->where('status', intval($filters['status']));
        }
    }

    /**
     * @param Builder $query
     * @param string  $search
     * @return void
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * @param int $id
     * @return void
     */
    public function calculateScore(int $id)
    {
        $olympiad = $this->find($id);
        $questionService = new QuestionService();

        foreach ($olympiad->results as $result) {
            $score = 0;
            $maxScore = 0;

            if (!is_null($result->answers)) {
                foreach ($result->answers as $questionId => $answerId) {
                    $question = $questionService->find($questionId);
                    $answer = $question->answers->where('id', $answerId)->first();
                    $maxScore += $question->correct_answer_cost;

                    if ($answer->is_correct) {
                        $score += $question->correct_answer_cost;
                    } else {
                        $score += $question->wrong_answer_cost;
                    }
                }

                $result->update([
                    'score' => $score,
                    'max_score' => $maxScore
                ]);
            }
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkOlympiadStatus(int $id): bool
    {
        $olympiad = $this->find($id);

        if ($olympiad->status !== Olympiad::STATUS_STARTED) {
            $this->failReason = __("This olympiad is ended or not started yet.");

            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $entry = Olympiad::find($id);

        $entry->post()->delete();

        $entry->delete();
    }

    /**
     * @param int $id
     * @return void
     */
    public function endOlympiad(int $id): void
    {
        $olympiad = $this->find($id);
        $olympiad->update([
            'status' => Olympiad::STATUS_ENDED
        ]);

        event(new OlympiadEndedEvent($olympiad));
    }

    /**
     * @param int|null $id
     * @return Olympiad|null
     */
    public function find(?int $id): ?Olympiad
    {
        return Olympiad::with('questions', 'results')->find($id);
    }

    /**
     * @return string
     */
    public function getFailReason(): string
    {
        return $this->failReason;
    }

    /**
     * @return Collection
     */
    public function getOlympiadsInProgress(): Collection
    {
        $results = Olympiad::where('status', Olympiad::STATUS_STARTED)
                           ->where('ends_at', '<=', now())
                           ->get();

        return $results;
    }

    /**
     * @param int $id
     * @return int
     */
    public function getParticipantsCount(int $id): int
    {
        $olympiad = Olympiad::where('status', Olympiad::STATUS_STARTED)->find($id);

        if (!$olympiad) {
            return 0;
        }

        $results = $olympiad->results()->get();

        return $results->count();
    }

    /**
     * @param int      $olympiadId
     * @param int|null $studentId
     * @return OlympiadResultDTO|Collection|null
     */
    public function getResults(int $olympiadId, int $studentId = null)
    {
        if (is_null($studentId)) {
            $results = OlympiadResult::where('olympiad_id', $olympiadId)
                                     ->get();

            return $results;
        }

        $result = OlympiadResult::where('olympiad_id', $olympiadId)
                                ->where('student_id', $studentId)
                                ->first();

        return $result ? (new OlympiadResultDTO())->transform($result) : null;
    }

    /**
     * @return string
     */
    public function getSignUpFailReason(): string
    {
        return $this->signUpFailReason;
    }

    /**
     * @return string
     */
    public function getStartFailReason(): string
    {
        return $this->startFailReason;
    }

    /**
     * @return array[]
     */
    public function getStatuses(): array
    {
        return [
            Olympiad::STATUS_CREATED => [
                'label' => __('Created'),
                'style' => 'warning'
            ],
            Olympiad::STATUS_STARTED => [
                'label' => __('In progress'),
                'style' => 'primary'
            ],
            Olympiad::STATUS_ENDED => [
                'label' => __('Ended'),
                'style' => 'success',
            ]
        ];
    }

    /**
     * @return Olympiad|null
     */
    public function getUpcomingOlympiad(): ?Olympiad
    {
        $result = Olympiad::where('status', Olympiad::STATUS_CREATED)
                           ->where('starts_at', '<=', now())
                           ->whereHas('questions')
                           ->first();

        return $result;
    }

    /**
     * @param int $status
     * @return bool
     */
    public function isDeletionAllowed(int $status): bool
    {
        return $status === Olympiad::STATUS_CREATED;
    }

    /**
     * @param int $status
     * @return bool
     */
    public function isEditingAllowed(int $status): bool
    {
        return $status === Olympiad::STATUS_CREATED;
    }

    /**
     * @param int $resultId
     * @return void
     */
    public function markFinished(int $resultId): void
    {
        OlympiadResult::where('id', $resultId)->update([
            'finished_at' => now()
        ]);
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new OlympiadDTO())->transform($i));
    }

    /**
     * @param int $studentId
     * @return bool
     */
    public function resendButton(int $studentId): bool
    {
        $olympiad = Olympiad::where('status', Olympiad::STATUS_STARTED)
                            ->orderBy('id', 'asc')
                            ->first();
        $student = (new StudentService())->find($studentId);

        $keyboard = new InlineKeyboardMarkup([
            [
                $olympiad->inlineMarkup($studentId)
            ]
        ]);
        (new TelegramService())->sendPhoto(
            $student->chat_id,
            config('app.url').'/storage/files/shares'.$olympiad->image,
            $olympiad->message($studentId),
            'HTML',
            $keyboard
        );

        return true;
    }

    /**
     * @param int $status
     * @return bool
     */
    public function resultsAvailable(int $status): bool
    {
        return $status === Olympiad::STATUS_ENDED;
    }

    /**
     * @param OlympiadValidatedDTO $dto
     * @return OlympiadDTO
     * @throws \Throwable
     */
    public function save(OlympiadValidatedDTO $dto): OlympiadDTO
    {
        $entry = null;

        \DB::transaction(function () use ($dto, &$entry) {
            $image = !is_null($dto->image) ? $this->uploadImage($dto->image, encodeTo: 'webp') : $dto->current_image;

            $description = str_replace('<div>', '', $dto->description);
            $description = str_replace('</div>', "\r\n", $description);
            $description = preg_replace('/\s+/', ' ', $description);

            $entry = Olympiad::updateOrCreate(['id' => $dto->id], [
                'title' => $dto->title,
                'description' => $description,
                'image' => $image,
                'starts_at' => $dto->starts_at,
                'ends_at' => $dto->ends_at,
                'time_limit' => $dto->time_limit,
                'status' => Olympiad::STATUS_CREATED
            ]);

            $entry = (new OlympiadDTO())->transform($entry);
        });

        return $entry;
    }

    /**
     * @param int $olympiadId
     * @param int $studentId
     * @return bool
     */
    public function signUp(int $olympiadId, int $studentId): bool
    {
        $olympiad = Olympiad::with('participants')->find($olympiadId);
        $participants = $olympiad->participants()->pluck('id')->toArray();

        if (in_array($studentId, $participants)) {
            $this->signUpFailReason = __('You are already signed up to this olympiad.');

            return false;
        }

        if ($olympiad->status === Olympiad::STATUS_ENDED) {
            $this->signUpFailReason = __('You cannot sign up to a olympiad which has ended.');

            return false;
        }

        $olympiad->participants()->create([
            'student_id' => $studentId
        ]);

        return true;
    }

    /**
     * @param int $id
     * @param int $studentId
     * @return bool
     */
    public function start(int $id, int $studentId): bool
    {
        $olympiad = Olympiad::find($id);

        if ($olympiad->status === Olympiad::STATUS_ENDED) {
            $this->startFailReason = __('The olympiad has ended.');

            return false;
        }

        $olympiad->results()->updateOrcreate([
            'student_id' => $studentId
        ], [
            'student_id' => $studentId
        ]);

        return true;
    }

    /**
     * @param int $id
     * @return void
     */
    public function startOlympiad(int $id): void
    {
        $olympiad = $this->find($id);
        $olympiad->update([
            'status' => Olympiad::STATUS_STARTED
        ]);

        event(new OlympiadStartedEvent($olympiad));
    }
}
