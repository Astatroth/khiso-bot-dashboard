<?php

namespace App\Services;

use App\DTOs\SeoDTO;
use App\DTOs\SeoValidatedDTO;
use App\Models\Seo;
use App\Traits\DynamicTableTrait;
use App\Traits\MediaTrait;
use App\Traits\SearchByAttributesTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SeoService
{
    use DynamicTableTrait;
    use MediaTrait;
    use SearchByAttributesTrait;

    /**
     * @var string
     */
    protected $model = Seo::class;

    /**
     * @param Builder $query
     * @param array   $filters
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        if (isset($filters['language'])) {
            if (!is_numeric($filters['language'])) {
                $query->where('language', $filters['language']);
            }
        }
    }

    /**
     * @param Builder $query
     * @param string  $search
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->where('path', 'like', "%{$search}%");
    }

    /**
     * @param string $contentType
     * @param int    $contentId
     * @return void
     */
    public function deleteContentTag(string $contentType, int $contentId): void
    {
        Seo::where([
            'content_type' => $contentType,
            'content_id' => $contentId
        ])->delete();
    }

    /**
     * @param int|null $id
     * @return SeoDTO|null
     */
    public function getEntry(int $id = null)
    {
        $entry = Seo::find($id);

        return $entry ? (new SeoDTO())->transform($entry) : null;
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new SeoDTO())->transform($i));
    }

    /**
     * @param SeoValidatedDTO $dto
     * @return void
     * @throws \Throwable
     */
    public function save(SeoValidatedDTO $dto): void
    {
        \DB::transaction(function () use ($dto) {
            $url = '/'.$dto->language.$dto->path;
            $image = !is_null($dto->og_image)
                ? $this->uploadImage($dto->og_image, encodeTo: 'webp')
                : ($dto->current_og_image ?? null);

            $data = [
                'language' => $dto->language,
                'path' => $dto->path,
                'description' => $dto->description,
                'og_type' => $dto->og_type,
                'og_url' => $url,
                'og_title' => $dto->og_title,
                'og_image' => $image,
                'content_type' => $dto->content_type,
                'content_id' => $dto->content_id
            ];

            Seo::updateOrCreate([
                'id' => $dto->seo_entry_id
            ], $data);
        });
    }
}
