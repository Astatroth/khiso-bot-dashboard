<?php

namespace App\Services;

use App\DTOs\News\NewsDTO;
use App\DTOs\News\NewsValidatedDTO;
use App\Models\News;
use App\Models\NewsMedia;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NewsService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = News::class;

    /**
     * @param int $status
     * @return bool
     */
    public function actionsAllowed(int $status): bool
    {
        return $status === News::STATUS_QUEUED || $status === News::STATUS_FAILED;
    }

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
        News::where('id', $id)->delete();
    }

    /**
     * @param int|null $id
     * @return News|null
     */
    public function find(?int $id): ?News
    {
        return News::with('media')->find($id);
    }

    /**
     * @return array[]
     */
    public function getStatuses(): array
    {
        return [
            News::STATUS_FAILED => [
                'label' => __('Failed'),
                'style' => 'danger'
            ],
            News::STATUS_QUEUED => [
                'label' => __('Queued'),
                'style' => 'warning'
            ],
            News::STATUS_SENDING => [
                'label' => __('Sending'),
                'style' => 'primary',
            ],
            News::STATUS_SENT => [
                'label' => __('Sent'),
                'style' => 'success'
            ]
        ];
    }

    /**
     * @param string $key
     * @return int
     */
    public function getType(string $key): int
    {
        $reflection = new \ReflectionClass(NewsMedia::class);

        return $reflection->getConstant('TYPE_'.strtoupper($key));
    }

    /**
     * @param Builder $query
     * @return void
     */
    protected function includeRelations(Builder &$query)
    {
        $query->with('media');
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new NewsDTO())->transform($i));
    }

    /**
     * @param NewsValidatedDTO $dto
     * @return ValidatedDTO
     * @throws \Throwable
     */
    public function save(NewsValidatedDTO $dto): ValidatedDTO
    {
        $entry = null;

        \DB::transaction(function () use ($dto, &$entry) {
            $entry = News::updateOrCreate(['id' => $dto->id], [
                'title' => $dto->title,
                'description' => strip_tags($dto->description, ['a', 'b', 'u', 'i']),
                'url' => $dto->url,
                'status' => News::STATUS_QUEUED
            ]);

            $entry->media()->whereNotIn('id', array_filter(\Arr::pluck($dto->media, 'id')))->delete();

            foreach ($dto->media as $media) {
                if (isset($media['src'])) {
                    if (isset($media['id'])) {
                        $entry->media()->where('id', $media['id'])->update([
                            'media_type' => $media['type'],
                            'media_url' => $media['src']
                        ]);
                    } else {
                        $entry->media()->create([
                            'media_type' => $media['type'],
                            'media_url' => $media['src']
                        ]);
                    }
                }
            }
        });

        return (new NewsDTO())->transform($entry);
    }
}
