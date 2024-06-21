<?php

namespace App\Services;

use App\DTOs\Olympiad\ResultDTO;
use App\Exports\OlympiadResultExport;
use App\Models\OlympiadResult;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class OlympiadResultService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = OlympiadResult::class;

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        $query->where('olympiad_id', $filters['olympiadId']);
    }

    /**
     * @param Builder $query
     * @param string  $search
     * @return void
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->whereHas('student.user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * @param Builder $query
     * @param array   $sorting
     * @return void
     */
    protected function applyListSorting(Builder &$query, array $sorting)
    {
        if ($sorting['column'] === 'time') {
            $query->orderByRaw("TIMEDIFF(created_at, finished_at)".$sorting['order']);
        }

        if ($sorting['column'] === 'fullname') {
            $query->with([
                'student.user' => fn ($query) => $query->orderBy('name', $sorting['order'])
            ]);
        }
    }

    public function export(int $id)
    {
        $olympiad = (new OlympiadService())->find($id);
        $results = OlympiadResult::with(['student'])->where('olympiad_id', $id)->get();

        if ($results->isEmpty()) {
            return false;
        }

        $results = $results->map(fn ($i) => (new ResultDTO())->transform($i));

        return new OlympiadResultExport($olympiad, $results);
    }

    /**
     * @param int|null $id
     * @return OlympiadResult|null
     */
    public function find(?int $id): ?OlympiadResult
    {
        return OlympiadResult::find($id);
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new ResultDTO())->transform($i));
    }
}
