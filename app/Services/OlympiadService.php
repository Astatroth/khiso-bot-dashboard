<?php

namespace App\Services;

use App\DTOs\Olympiad\OlympiadDTO;
use App\DTOs\Olympiad\OlympiadValidatedDTO;
use App\Events\OlympiadEndedEvent;
use App\Events\OlympiadStartedEvent;
use App\Models\Olympiad;
use App\Traits\DynamicTableTrait;
use App\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
    protected $signUpFailReason = null;

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
        return Olympiad::find($id);
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
     * @return string
     */
    public function getSignUpFailReason(): string
    {
        return $this->signUpFailReason;
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
     * @return Collection
     */
    public function getUpcomingOlympiads(): Collection
    {
        $results = Olympiad::where('status', Olympiad::STATUS_CREATED)
                           ->where('starts_at', '<=', now())
                           ->get();

        return $results;
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
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new OlympiadDTO())->transform($i));
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

            $entry = Olympiad::updateOrCreate(['id' => $dto->id], [
                'title' => $dto->title,
                'description' => $dto->description,
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
